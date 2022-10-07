@extends('master')
@section('content')
<div id="app" class="container">
    <div v-if="is_success" class="alert alert-success">
        @{{mess}}
    </div>
    <div v-if="is_danger" class="alert alert-danger">
        @{{mess}}
    </div>
    <form>
        <input class="form-control mt-1" type="file" v-on:change="onChange($event)" id="formFile">
        <label for="">answer</label>
        <input type="text" v-model="answer" v-on:keyup="onChange_slug" placeholder="nhập vô đây" style="width: 400px;">=>
        <input type="text" disabled v-model="slug" style="width: 400px;"><br>
        <button class="btn btn-success mt-1 mr-1 col-3" type="button" v-on:click="upload($event)">Upload</button>
        <button class="btn btn-dark mt-1 col-3" type="reset">clear</button>
    </form>
</div>
@endsection
@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.7.10/vue.min.js"></script>
    <script>
        var app = new Vue({
            el : "#app",
            data : {
                'file' : '',
                'is_success' : false,
                'is_danger' : false,
                'mess' : '',
                'answer' : '',
                'slug' : ''
            },
            methods:{
                onChange(e){
                    this.file = e.target.files[0];
                },
                toSlug(str) {
                    str = str.toLowerCase();
                    str = str
                        .normalize('NFD')
                        .replace(/[\u0300-\u036f]/g, '');
                    str = str.replace(/[đĐ]/g, 'd');
                    str = str.replace(/([^0-9a-z-\s])/g, '');
                    str = str.replace(/(\s+)/g, '');
                    str = str.replace(/-+/g, '');
                    str = str.replace(/^-+|-+$/g, '');
                    return str;
                },
                upload(e){
                    e.preventDefault();
                    if (this.answer === ''){
                        toastr.error("đáp án k đc để trống")
                    } else {
                        toastr.info("Processing!")
                        const config = {
                            headers: {
                                'content-type': 'multipart/form-data'
                            }
                        }
                        let data = new FormData();
                        data.append('file', this.file);
                        data.append('slug', this.slug);
                        axios
                            .post('/create', data, config)
                            .then((res) => {
                                this.is_success = false
                                this.is_danger = false
                                if (res.data.status){
                                    this.is_success = true
                                    this.mess = 'Your file is save in ' + res.data.path
                                    toastr.success("OK")
                                    $(".btn-dark").click()
                                } else {
                                    this.is_danger = true
                                    this.mess = 'Error : ' + res.data.message
                                }
                            })
                            .catch((res) => {
                                var errors = res.response.data.errors;
                                $.each(errors, function (key, value) {
                                    toastr.error(value[0]);
                                });
                            });
                    }
                },
                onChange_slug(){
                    this.slug = this.toSlug(this.answer)
                }
            }
        })
    </script>
@endsection

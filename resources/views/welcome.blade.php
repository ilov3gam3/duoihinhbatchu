<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Học bảo mật nhưng phải đi làm dev :<</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/file.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
</head>
<body>
<div class="" id="app">
    <form>
        <label for="">chọn số câu</label>
        <select v-model="id.id">
            <template v-for="item in list_id">
                <option v-bind:value="item.id">@{{ item.id }}</option>
            </template>
        </select>
        <button type="button" v-on:click="view_question()" class="btn btn-success">xem câu hỏi</button>
    </form>
    <div class="d-flex align-items-center justify-content-center m-1">
        <img v-bind:src="this.image_path" alt="">
    </div>
    <div class="d-flex align-items-center justify-content-center m-1">
        <form>
            <input class="form-control" type="text" v-model="user_answer">
            <div class="row d-flex align-items-center justify-content-center">
                <button class="btn btn-success m-1" v-on:click="checkAnswer($event)">CONFIRM</button>
                <button type="reset" class="btn btn-danger m-1">CLEAR</button>
            </div>
        </form>

    </div>

</div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.7.10/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    function clickEvent(first, last) {
        if (first.value.length) {
            document.getElementById(last).focus();
        }
    }
</script>
<script>
    var app = new Vue({
        el: "#app",
        data: {
            'num_ques': 0,
            'image_path': '',
            'question_number': '',
            'list_id': [],
            'id': {},
            'answer': '',
            'user_answer': ''
        },
        created() {
            this.loadQuestionId()
        },
        methods: {
            loadQuestionId() {
                axios
                    .get('/get_question_id')
                    .then((res) => {
                        this.list_id = res.data.data
                    })
            },
            view_question() {
                axios
                    .post('/get_question', this.id)
                    .then((res) => {
                        this.image_path = res.data.data.img_path
                        this.answer = res.data.data.answer
                    })
            },
            checkAnswer(e) {
                e.preventDefault()
                if (this.user_answer === this.answer){
                    toastr.success("đúng r bạn êi")
                } else {
                    toastr.error('sai r bạn êi')
                }
            },
        }
    })
</script>
</html>

const utils = require('../utils.js')

const page = {
    bindEvens: function(){
        $('#form-alter-password').on('submit', page.changePass)
        $('#form-alter-login').on('submit', page.changeLogin)
    },
    changePass: function(etv){
        etv.preventDefault()
        utils.load.start()
        $.ajax({
            url: 'user/change-pass',
            type: 'post',
            dataType: 'json',
            data: {
                password: $('#password').val(),
                confirm_password: $('#confirm_password').val(),
            },
            success: (resp)=>{
                utils.load.stop()
                if(resp.status){
                    utils.success({title: 'Salvo!'})
                    $('#modal-alter-password').modal('hide')
                    $('#password').val('')
                    $('#confirm_password').val('')
                } else{
                    utils.setError({msg: resp.msg})
                }   
            }, error (e){
                utils.load.stop()
                utils.setError({msg: e.responseJSON.message})
            }
        })
    },
    changeLogin: function(etv){
        etv.preventDefault()
        utils.load.start()
        $.ajax({
            url: 'user/change-login',
            type: 'post',
            dataType: 'json',
            data: {
                login: $('#login').val(),
            },
            success: (resp)=>{
                utils.load.stop()
                if(resp.status){
                    utils.success({title: 'Salvo!'})
                    $('#modal-alter-login').modal('hide')
                    $('#login').val('')
                } else{
                    utils.setError({msg: resp.msg})
                }   
            }, error (e){
                utils.load.stop()
                utils.setError({msg: e.responseJSON.message})
            }
        })
    }
}

$(document).ready(function(){
    page.bindEvens()
})
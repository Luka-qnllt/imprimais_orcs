const utils = {
    status: {
        1: 'Entregue',
        2: 'Concluído',
        3: 'Em Andamento',
        4: 'Aguardando Aprovação',
        5: 'Não Iniciado'
    },
    prior: {
        1: 'Alta',
        2: 'Média',
        3: 'Baixa'
    },
    serializeObject: function serializeObject(form) {
        var obj = {};
        var array = form.serializeArray();
        $.each(array, function () {
          if (obj[this.name]) {
            if (!obj[this.name].push) {
              obj[this.name] = [obj[this.name]];
            }
    
            obj[this.name].push(this.value || '');
          } else {
            if (this.name.match(']')) {
              obj[this.name] = [];
              obj[this.name].push(this.value || '');
            } else {
              obj[this.name] = this.value || '';
            }
          }
        });
        return obj;
    },
    setError: function(opt = {}){
        Swal.fire({
            type: 'error',
            title: opt.msg,
            html: opt.body ? opt.body : ''
        })
    },
    load: {
        start: function(){
            $('.pace').css('z-index', '15000')
            $('.pace').removeClass('pace-inactive')
            $('.pace').addClass('pace-active')
        },
        stop: function(){
            $('.pace').removeClass('pace-active')
            $('.pace').addClass('pace-inactive')
        }
    },
    success: function(opt = {}){
        Swal.fire({
            type: 'success',
            title: opt.title,
            html: '<p>' + (opt.msg ? opt.msg : '') + '</p>',
            timer: 1000,
            showConfirmButton: false,
            didOpen: () => {
              Swal.showLoading()
              timerInterval = setInterval(() => {
                const content = Swal.getContent()
                if (content) {
                  const b = content.querySelector('b')
                  if (b) {
                    b.textContent = Swal.getTimerLeft()
                  }
                }
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          })
    },
    toMoney: function(str){
        if(str == null || str == '')
            return '0,00'

        if(parseFloat(str) > 0){
    
            let val = parseFloat(str).toFixed(2)
            let array = parseFloat(val).toLocaleString("pt-BR", {currency:"BRL"}).split(',')
            
            let decimal = array[1] ? array[1].padEnd(2, '0') : '00'
            return( array[0] + ',' + decimal )
        } else {
            return '0,00'
        }
    },
    formartDate: function(str, time=false){
        if(str == null) return '-'
        const dateTimeSplit = str.match('T') ? str.split('T') : str.split(' ')

        const parts = dateTimeSplit[0].split('-')
        const day = parts[2]
        const month = parts[1]
        const year = parts[0]
        
        return day + '/' + month + '/' + year + (dateTimeSplit[1] && time ? (' ' + dateTimeSplit[1]) : '')
    },
    confirm: function(opt = {}){
        Swal.fire({
            type: 'warning',
            title: opt.title,
            html: '<p>' + (opt.msg ? opt.msg : '') + '</p>',
            showCancelButton: true,
            confirmButtonText: opt.textBtnConfirm || 'OK',
            cancelButtonText: opt.textBtnCancel || 'Cancelar',
        }).then((result)=>{
            // console.log(result)
            if(result.value) {
                opt.onConfirm && opt.onConfirm()
            } else {
                opt.onCancel && opt.onCancel()
            }
        })
    },
    unMaskMoney: function(str){
        str = str.replaceAll('.', '').replaceAll(',', '.').replaceAll(' ', '').replace('R$', '')
        str = parseFloat(str)
        if( isNaN(str) ){
            return false
        } else {
            return str
        }
    }, 
}

module.exports = utils
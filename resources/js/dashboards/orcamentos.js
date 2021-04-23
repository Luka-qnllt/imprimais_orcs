const utils = require('../utils.js')

const page = {
    bindEvents: ()=>{
        $('#open-modal-orc').on('click', function(){
            page.resetForm()
            $('#modal-orc').modal('show')
        })
        $('#btn-add-item').on('click', function(){
            const data = {
                titulo: $('#new-item-item').val(),
                qtd: $('#new-item-qtd').val(),
                valor_un: $('#new-item-valor-un').val(),
            }
            if(data.titulo != '' && data.titulo != null )
                page.addItem(data)
        })
        $('#itens-wrap').on('click', '.btn-remove-item', page.removeItem)
        $('#form-orc').on('submit', function(evt){
            evt.preventDefault()
            const id = $(this).find('[name=id]').val()
            if( id == null || id == '' ){
                page.create()
            } else {
                page.update(id)
            }
        })
        $('#orcs-wrap').on('click', '.btn-edit', function(){page.get($(this).data('id'))})
        $('#orcs-wrap').on('click', '.btn-delete', function(){
            const id = $(this).data('id')
            utils.confirm({
                title: 'Deseja deletar este registro?',
                confirmButtonText: 'Sim, deletar',
                onConfirm: ()=>{page.delete(id)}
            })
        })
        $('#btn-search').on('click', page.list)
        $('#btn-clean-seach').on('click', function(){
            $('#search-inicio').val('')
            $('#search-status').val('')
            $('#search-pagamento').val('PD')
            $('#search-prioridade').val('')
        })
    },
    resetForm: function(){
        $('#form-orc').trigger('reset')
        $('#form-orc').find('[name=id]').val('')
        $('#itens-wrap').html('')
    },
    addItem: function(data){
        const index = page.geraIndex()

        const valor_un = data.id == null || data.id == '' ? utils.unMaskMoney(data.valor_un) : data.valor_un

        const total = !isNaN(valor_un * parseFloat(data.qtd)) ? valor_un * parseFloat(data.qtd) : 0
        const content = `
            <tr class="item item-added" id="item-${index}">
                <input type="hidden" name='item_id[]' value='${data.id || ''}'>
                <td class="p-0 index-item">#</td>
                <td class="p-0"><input type="text" class="form-control border-0" name='item_titulo[]' value='${data.titulo}'></td>
                <td class="p-0"><input type="number" min='0' class="form-control border-0" name='item_qtd[]' value='${data.qtd || 0}'></td>
                <td class="p-0"><input type="text" class="form-control border-0 money" name='item_valor_un[]' value='${utils.toMoney(valor_un)}'></td>
                <td class="p-0 total-item" data-valor="${total}">${utils.toMoney(total)}</td>
                <td class="p-0"><i class="fa fa-times text-danger hover btn-remove-item" data-id="${data.id || ''}" data-index="${index}"></i></td>
            </tr>`

        $('#itens-wrap').append(content)
        page.atualizaIndexItem()
        page.atualizeTotalItens()
        $('.item-reset').val('')
        $('.money').maskMoney({decimal: ',', thousands: '.'})
    },
    atualizeTotalItens: function(){
        let total = 0
        $('.total-item').each((i, el)=>{
            total += parseFloat($(el).data('valor'))
        })
        $('#total-itens').html(utils.toMoney(total))
    },
    atualizaIndexItem: function(){
        $('.index-item').each((i, el)=>{
            $(el).html(i + 1)
        })
    },
    geraIndex: function(index=1){
        index += $('.item').length
        if( $(`#item-${index}`).length > 0 ){
            return page.geraIndex(index)
        } else {
            return index;
        }
    },
    create: function(){
        utils.load.start()
        $.ajax({
            url: '/orcamentos/ajax/save',
            type: 'post',
            dataType: 'json',
            data: utils.serializeObject($('#form-orc')),
            success: (resp)=>{
                utils.load.stop()
                if(resp.status){
                    page.get(resp.data.id)
                    page.list()
                    utils.success({title: 'Salvo!'})
                }
            },
            error: (e)=>{
                utils.load.stop()
                console.error(e)
            }
        })
    },
    update: function(id){
        utils.load.start()
        $.ajax({
            url: '/orcamentos/ajax/update/'+id,
            type: 'post',
            dataType: 'json',
            data: utils.serializeObject($('#form-orc')),
            success: (resp)=>{
                utils.load.stop()
                if(resp.status){
                    page.get(id)
                    page.list()
                    utils.success({title: 'Salvo!'})
                }
            },
            error: (e)=>{
                utils.load.stop()
                console.error(e)
            }
        })
    },
    list: function(){
        utils.load.start()
        $.ajax({
            url: '/orcamentos/ajax/list',
            type: 'post',
            dataType: 'json',
            data: {
                inicio: $('#search-inicio').val(),
                status: $('#search-status').val(),
                pagamento: $('#search-pagamento').val(),
                prioridade: $('#search-prioridade').val(),
            },
            success: (resp)=>{
                utils.load.stop()
                
                let infos = {
                    receber: 0,
                    recebido: 0,   
                    pendentes: 0,
                }

                let content = ''
                for(const orc of resp.data){

                    //tr color
                    let trClass = ''
                    if(orc.pagamento == 'PG'){                        
                        trClass = 'success'
                    } else if (orc.prioridade == 1 && orc.status > 2 ){                       
                        trClass = 'warning'
                    } else if (orc.status == 1 && orc.pagamento == 'PD') {
                        trClass = 'danger'
                    }

                    //infos
                    if(orc.pagamento == 'PG'){                        
                        infos.recebido += parseFloat(orc.valor_total)
                    }
                    if( orc.status > 2 ){
                        infos.pendentes++
                    }
                    if( orc.status == 1 && orc.pagamento == 'PD' ){
                        infos.receber += parseFloat(orc.valor_total)
                    }
                    
                    content += `
                            <tr class="hover btn-edit ${trClass}" data-id="${orc.id}">
                                <td>${orc.nota_fiscal || '-'}</td>
                                <td>${orc.pedido || '-'}</td>
                                <td>${orc.solicitante || '-'}</td>
                                <td>${utils.formartDate(orc.inicio) || '-'}</td>
                                <td>${utils.status[orc.status] || '-'}</td>
                                <td>${utils.toMoney(orc.valor_total) || '-'}</td>
                                <td>
                                    <a class="btn btn-sm btn-danger flot-right btn-delete text-white" data-id="${orc.id}"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>`
                }
                $('#table-orc').DataTable().destroy()
                $('#orcs-wrap').html(content)
                $('#table-orc').DataTable({"language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                }})

                //infos
                $('#receber').html(utils.toMoney(infos.receber))
                $('#recebido').html(utils.toMoney(infos.recebido))
                $('#pendentes').html(infos.pendentes)
            },
            error: (e)=>{
                utils.load.stop()
                console.error(e)
            }
        })
    },
    get: function(id){
        utils.load.start()
        $.ajax({
            url: '/orcamentos/ajax/get/'+id,
            type: 'post',
            dataType: 'json',
            success: (resp)=>{
                utils.load.stop()
                $('#itens-wrap').html('')
                page.setValueOrc(resp.data)
            },
            error: (e)=>{
                utils.load.stop()
                console.error(e)
            }
        })
    },
    setValueOrc: function(data){
        console.log(data)
        const form = $('#form-orc')
        for(let i in data){
            const element = form.find(`[name=${i}]`)
            if((element).is('.money')){
                element.val(utils.toMoney(data[i]))
            } else {
                element.val(data[i] || '')
            }
        }

        for(const item of data.itens){
            const dataItem = {
                id: item.id,
                titulo: item.titulo,
                qtd: item.qtd,
                valor_un: item.valor_un
            }
            page.addItem(dataItem)
        }
        $('#modal-orc').modal('show')
    },
    delete: function(id){
        utils.load.start()
        $.ajax({
            url: '/orcamentos/ajax/delete/'+id,
            type: 'post',
            dataType: 'json',
            success: (resp)=>{
                utils.load.stop()
                page.resetForm()
                page.list()
                $('#modal-orc').modal('hide')
                utils.success({msg: 'Deletado'})
            },
            error: (e)=>{
                utils.load.stop()
                console.error(e)
            }
        })
    },
    removeItem: function(){
        const index = $(this).data('index')
        const id = $(this).data('id')

        if(id != null && id != ''){
            utils.load.start()
            $.ajax({
                url: '/orcamentos/ajax/delete-item/'+id,
                type: 'post',
                dataType: 'json',
                success: (resp)=>{
                    utils.load.stop()
                    $(`tr#item-${index}`).remove()
                    page.atualizaIndexItem()
                    page.atualizeTotalItens()

                },
                error: (e)=>{
                    utils.load.stop()
                    console.error(e)
                }
            })
        } else {
            $(`tr#item-${index}`).remove()
            page.atualizaIndexItem()
            page.atualizeTotalItens()
        }
    }
}

$(document).ready(function(){
    page.bindEvents()
    page.list()
    $('.money').maskMoney({decimal: ',', thousands: '.'})
})
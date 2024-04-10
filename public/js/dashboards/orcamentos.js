(()=>{var t={581:t=>{var e={status:{1:"Entregue",2:"Concluído",3:"Em Andamento",4:"Aguardando Aprovação",5:"Não Iniciado"},prior:{1:"Alta",2:"Média",3:"Baixa"},serializeObject:function(t){var e={},a=t.serializeArray();return $.each(a,(function(){e[this.name]?(e[this.name].push||(e[this.name]=[e[this.name]]),e[this.name].push(this.value||"")):this.name.match("]")?(e[this.name]=[],e[this.name].push(this.value||"")):e[this.name]=this.value||""})),e},setError:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};Swal.fire({type:"error",title:t.msg,html:t.body?t.body:""})},load:{start:function(){$(".pace").css("z-index","15000"),$(".pace").removeClass("pace-inactive"),$(".pace").addClass("pace-active")},stop:function(){$(".pace").removeClass("pace-active"),$(".pace").addClass("pace-inactive")}},success:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};Swal.fire({type:"success",title:t.title,html:"<p>"+(t.msg?t.msg:"")+"</p>",timer:1e3,showConfirmButton:!1,didOpen:function(){Swal.showLoading(),timerInterval=setInterval((function(){var t=Swal.getContent();if(t){var e=t.querySelector("b");e&&(e.textContent=Swal.getTimerLeft())}}),100)},willClose:function(){clearInterval(timerInterval)}})},toMoney:function(t){if(null==t||""==t)return"0,00";if(parseFloat(t)>0){var e=parseFloat(t).toFixed(2),a=parseFloat(e).toLocaleString("pt-BR",{currency:"BRL"}).split(","),n=a[1]?a[1].padEnd(2,"0"):"00";return a[0]+","+n}return"0,00"},formartDate:function(t){var e=arguments.length>1&&void 0!==arguments[1]&&arguments[1];if(null==t)return"-";var a=t.match("T")?t.split("T"):t.split(" "),n=a[0].split("-"),o=n[2],r=n[1],i=n[0];return o+"/"+r+"/"+i+(a[1]&&e?" "+a[1]:"")},confirm:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};Swal.fire({type:"warning",title:t.title,html:"<p>"+(t.msg?t.msg:"")+"</p>",showCancelButton:!0,confirmButtonText:t.textBtnConfirm||"OK",cancelButtonText:t.textBtnCancel||"Cancelar"}).then((function(e){e.value?t.onConfirm&&t.onConfirm():t.onCancel&&t.onCancel()}))},unMaskMoney:function(t){return t=t.replaceAll(".","").replaceAll(",",".").replaceAll(" ","").replace("R$",""),t=parseFloat(t),!isNaN(t)&&t}};t.exports=e}},e={};function a(n){var o=e[n];if(void 0!==o)return o.exports;var r=e[n]={exports:{}};return t[n](r,r.exports,a),r.exports}(()=>{function t(t,a){var n;if("undefined"==typeof Symbol||null==t[Symbol.iterator]){if(Array.isArray(t)||(n=function(t,a){if(!t)return;if("string"==typeof t)return e(t,a);var n=Object.prototype.toString.call(t).slice(8,-1);"Object"===n&&t.constructor&&(n=t.constructor.name);if("Map"===n||"Set"===n)return Array.from(t);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return e(t,a)}(t))||a&&t&&"number"==typeof t.length){n&&(t=n);var o=0,r=function(){};return{s:r,n:function(){return o>=t.length?{done:!0}:{done:!1,value:t[o++]}},e:function(t){throw t},f:r}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,l=!0,s=!1;return{s:function(){n=t[Symbol.iterator]()},n:function(){var t=n.next();return l=t.done,t},e:function(t){s=!0,i=t},f:function(){try{l||null==n.return||n.return()}finally{if(s)throw i}}}}function e(t,e){(null==e||e>t.length)&&(e=t.length);for(var a=0,n=new Array(e);a<e;a++)n[a]=t[a];return n}var n=a(581),o={bindEvents:function(){$("#open-modal-orc").on("click",(function(){o.resetForm(),$("#modal-orc").modal("show")})),$("#btn-add-item").on("click",(function(){var t={titulo:$("#new-item-item").val(),qtd:$("#new-item-qtd").val(),valor_un:$("#new-item-valor-un").val()};""!=t.titulo&&null!=t.titulo&&o.addItem(t)})),$("#itens-wrap").on("click",".btn-remove-item",o.removeItem),$("#form-orc").on("submit",(function(t){t.preventDefault();var e=$(this).find("[name=id]").val();null==e||""==e?o.create():o.update(e)})),$("#orcs-wrap").on("click",".btn-edit",(function(){o.get($(this).data("id"))})),$("#orcs-wrap").on("click",".btn-delete",(function(t){t.stopPropagation();var e=$(this).data("id");n.confirm({title:"Deseja deletar este registro?",confirmButtonText:"Sim, deletar",onConfirm:function(){o.delete(e)}})})),$("#form-search").on("submit",(function(t){t.preventDefault(),o.list()})),$("#btn-clean-seach").on("click",(function(){$("#search-conteudo").val(""),$("#search-inicio").val(""),$("#search-status").val(""),$("#search-pagamento").val("PD"),$("#search-prioridade").val("")})),$("#send-mail").on("click",o.setValuesMail),$("#form-mail").on("submit",o.sendMail),$(".modal").on("hidden.bs.modal",(function(){$(".modal").css("orverflow","auto")}))},resetForm:function(){$("#orc-modal-title").html("Novo orçamento"),$("#form-orc").trigger("reset"),$("#form-orc").find("[name=id]").val(""),$("#itens-wrap").html(""),$("#form-pdf").css("display","none"),$("#send-mail").css("display","none")},addItem:function(t){var e=o.geraIndex(),a=null==t.id||""==t.id?n.unMaskMoney(t.valor_un):t.valor_un,r=isNaN(a*parseFloat(t.qtd))?0:a*parseFloat(t.qtd),i='\n            <tr class="item item-added" id="item-'.concat(e,"\">\n                <input type=\"hidden\" name='item_id[]' value='").concat(t.id||"",'\'>\n                <td class="p-0 index-item">#</td>\n                <td class="p-0"><input type="text" class="form-control border-0" name=\'item_titulo[]\' value=\'').concat(t.titulo,"'></td>\n                <td class=\"p-0\"><input type=\"number\" min='0' class=\"form-control border-0\" name='item_qtd[]' value='").concat(t.qtd||0,'\'></td>\n                <td class="p-0"><input type="text" class="form-control border-0 money" name=\'item_valor_un[]\' value=\'').concat(n.toMoney(a),'\'></td>\n                <td class="p-0 total-item" data-valor="').concat(r,'">').concat(n.toMoney(r),'</td>\n                <td class="p-0"><i class="fa fa-times text-danger hover btn-remove-item" data-id="').concat(t.id||"",'" data-index="').concat(e,'"></i></td>\n            </tr>');$("#itens-wrap").append(i),o.atualizaIndexItem(),o.atualizeTotalItens(),$(".item-reset").val(""),$(".money").maskMoney({decimal:",",thousands:"."})},atualizeTotalItens:function(){var t=0;$(".total-item").each((function(e,a){t+=parseFloat($(a).data("valor"))})),$("#total-itens").html(n.toMoney(t)),$("#form-orc").find("[name=valor_total]").val(n.toMoney(t))},atualizaIndexItem:function(){$(".index-item").each((function(t,e){$(e).html(t+1)}))},geraIndex:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:1;return t+=$(".item").length,$("#item-".concat(t)).length>0?o.geraIndex(t):t},create:function(){n.load.start(),$.ajax({url:"/orcamentos/ajax/save",type:"post",dataType:"json",data:n.serializeObject($("#form-orc")),success:function(t){n.load.stop(),t.status&&(o.get(t.data.id),o.list(),n.success({title:"Salvo!"}))},error:function(t){n.load.stop(),console.error(t)}})},update:function(t){n.load.start(),$.ajax({url:"/orcamentos/ajax/update/"+t,type:"post",dataType:"json",data:n.serializeObject($("#form-orc")),success:function(e){n.load.stop(),e.status&&(o.get(t),o.list(),n.success({title:"Salvo!"}))},error:function(t){n.load.stop(),console.error(t)}})},list:function(){n.load.start(),$.ajax({url:"/orcamentos/ajax/list",type:"post",dataType:"json",data:{conteudo:$("#search-conteudo").val(),inicio:$("#search-inicio").val(),status:$("#search-status").val(),pagamento:$("#search-pagamento").val(),prioridade:$("#search-prioridade").val()},success:function(e){n.load.stop();var a,o=$(".page-item.active a").data("dt-idx")?$(".page-item.active a").data("dt-idx"):1,r={receber:0,recebido:0,pendentes:0},i="",l=t(e.data);try{for(l.s();!(a=l.n()).done;){var s=a.value,c="";"PG"==s.pagamento?c="success":1==s.prioridade&&s.status>2?c="warning":1==s.status&&"PD"==s.pagamento&&(c="danger"),"PG"==s.pagamento&&(r.recebido+=parseFloat(s.valor_total)),s.status>2&&r.pendentes++,1==s.status&&"PD"==s.pagamento&&(r.receber+=parseFloat(s.valor_total)),i+='\n                            <tr class="hover btn-edit '.concat(c,'" data-id="').concat(s.id,'">\n                                <td>').concat(s.id,"</td>\n                                <td>").concat(s.nota_fiscal||"-","</td>\n                                <td>").concat(s.pedido||"-","</td>\n                                <td>").concat(s.solicitante||"-","</td>\n                                <td>").concat(s.area||"-","</td>\n                                <td>").concat(n.formartDate(s.inicio)||"-","</td>\n                                <td>").concat(n.status[s.status]||"-","</td>\n                                <td>").concat(n.toMoney(s.valor_total)||"-",'</td>\n                                <td>\n                                    <button type="button" class="btn btn-sm btn-outline-danger flot-right btn-delete" data-id="').concat(s.id,'"><i class="fa fa-trash"></i></button>\n                                </td>\n                            </tr>')}}catch(t){l.e(t)}finally{l.f()}$("#table-orc").DataTable().destroy(),$("#orcs-wrap").html(i);$("#table-orc").DataTable({language:{url:"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"},pageLength:50,order:[[0,"desc"]]});setTimeout((function(){$(".page-item a[data-dt-idx=".concat(o,"]")).click()}),100),$("#receber").html(n.toMoney(r.receber)),$("#recebido").html(n.toMoney(r.recebido)),$("#pendentes").html(r.pendentes)},error:function(t){n.load.stop(),console.error(t)}})},get:function(t){n.load.start(),$.ajax({url:"/orcamentos/ajax/get/"+t,type:"post",dataType:"json",success:function(t){n.load.stop(),$("#itens-wrap").html(""),o.setValueOrc(t.data)},error:function(t){n.load.stop(),console.error(t)}})},setValueOrc:function(e){var a=$("#form-orc");for(var r in e){var i=a.find("[name=".concat(r,"]"));i.is(".money")?i.val(n.toMoney(e[r])):i.val(e[r]||"")}var l,s=t(e.itens);try{for(s.s();!(l=s.n()).done;){var c=l.value,d={id:c.id,titulo:c.titulo,qtd:c.qtd,valor_un:c.valor_un};o.addItem(d)}}catch(t){s.e(t)}finally{s.f()}$("#orc-modal-title").html("Orçamento ".concat(e.id)),$("#form-pdf").attr("action","/orcamentos/pdf-orcamento/"+e.id),$("#form-pdf").css("display","initial"),$("#send-mail").css("display","initial"),$("#modal-orc").modal("show")},delete:function(t){n.load.start(),$.ajax({url:"/orcamentos/ajax/delete/"+t,type:"post",dataType:"json",success:function(t){n.load.stop(),o.resetForm(),o.list(),$("#modal-orc").modal("hide"),n.success({msg:"Deletado"})},error:function(t){n.load.stop(),console.error(t)}})},removeItem:function(){var t=$(this).data("index"),e=$(this).data("id");null!=e&&""!=e?(n.load.start(),$.ajax({url:"/orcamentos/ajax/delete-item/"+e,type:"post",dataType:"json",success:function(e){n.load.stop(),$("tr#item-".concat(t)).remove(),o.atualizaIndexItem(),o.atualizeTotalItens()},error:function(t){n.load.stop(),console.error(t)}})):($("tr#item-".concat(t)).remove(),o.atualizaIndexItem(),o.atualizeTotalItens())},setValuesMail:function(){var t=$("#form-orc"),e=$("#form-mail"),a=t.find("[name=id]").val(),n=t.find("[name=email]").val().toLowerCase();e.find("[name=email]").val(n),e.find("[name=id_orc]").val(a),$("#modal-mail").modal("show")},sendMail:function(t){t.preventDefault();var e=$("#form-mail"),a=e.find("[name=id_orc]").val();n.load.start(),$.ajax({url:"/orcamentos/ajax/send-mail/"+a,type:"post",dataType:"json",data:{email:e.find("[name=email]").val(),message:e.find("[name=message]").val()},success:function(t){n.load.stop(),t.status?(e.find("[name=email]").val(""),e.find("[name=message]").val(""),e.find("[name=id_orc]").val(""),$("#modal-mail").modal("hide"),n.success({title:"Email enviado com sucesso!"})):n.setError({msg:t.msg||"Falha ao enviar email"})},error:function(t){n.load.stop(),n.setError({msg:t.responseText}),console.error(t)}})},ddImgForm:function(){var t,e=$("#drop-box"),a=("draggable"in(t=document.createElement("div"))||"ondragstart"in t&&"ondrop"in t)&&"FormData"in window&&"FileReader"in window,n=$("#file"),o=$(".box__filename"),r=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",e=t,a=t.split(".");fistName=a.slice(0,a.length-1).join("."),fistName.length>19&&(e=fistName.replace(/(?<=^.{8}).*(?=.{8}?)/,"...")+"."+a.slice(a.length-1)),o.text(e)};if(a){var i=!1;e.on("drag dragstart dragend dragover dragenter dragleave drop",(function(t){t.preventDefault(),t.stopPropagation()})).on("dragover dragenter",(function(){e.addClass("is-dragover")})).on("dragleave dragend drop",(function(){e.removeClass("is-dragover")})).on("drop",(function(t){i=t.originalEvent.dataTransfer.files,r(i[0].name)})),n.on("change",(function(t){r(t.target.files[0].name)}))}}};$((function(){o.bindEvents(),o.list(),$(".money").maskMoney({decimal:",",thousands:"."}),$(".modal").css("orverflow","auto")}))})()})();
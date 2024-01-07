$(document).ready(() => {
    let retorno = ''
    

    $("#todos_ativos").on("click", (e) => {
        $("li").removeClass("btn_click")
        $("#todos_ativos").addClass("btn_click")
        $("#area_cards_row").html("")
        $("#area_cards_select").html("")
        let chamada = {
            url: "backend.php",
            type: "GET",
            data: "acao=todos_dados",
            dataType: "json",
            success: (data) => {

                $("#area_cards_row").html("")
                for (let i = 0; i < data.length; i++) {
                    let aux = parseInt(data[i].total_investido)
                    let valor = aux.toLocaleString("pt-BR", { style: "currency", currency: "BRL" });


                    $("#area_cards_row").append(`<div class="col-auto card  cards_config" ><div class="card-header card-title background_titulo">` + `<strong>${data[i].cod}</strong>` + `</div><div class="card-body">` + "<strong>Qtd= </strong>" + data[i].quant + " ações" + `</div><div class="card-footer">` + "<strong>Total:</strong> " + valor + `</div></div>`)

                }
                $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
                $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
                $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)

            }
        }
        $.ajax(chamada)

    });

    $("#todos_ativos").trigger("click")

    $("#cnpj").on("click", (e) => {
    
        $("li").removeClass("btn_click")
        $("#cnpj").addClass("btn_click")
        $("#area_cards_row").html("")
        $("#area_cards_select").html("")

        let chamada2 = {
            url: "backend.php",
            type: "get",
            data: "acao=procurar_cnpj",
            dataType: "json",
            success: (data) => {
                $("#area_cards_row").html("")
                for (i = 0; i < data.length; i++) {
                    $("#area_cards_row").append(`<div class="col-auto card  cards_config" ><div class="card-header card-title background_titulo">` + `<strong>${data[i].cod}</strong>` + `</div><div class="card-body">` + "<strong>CNPJ:</strong>" + `<input readOnly id='cnpj_copiar_${data[i].cod}' value=${data[i].cnpj} class='form-control text-truncate'>` +`<button onclick="copiar('cnpj_copiar_${data[i].cod}')" class='btn btn-light form-control'><strong>Copiar Cnpj</strong>    <i class="fa-solid fa-copy fa-bounce"></i></button>`+`</div><div class="card-footer">` + `</div></div>`)
                }
                $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
                $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
                $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
            }
        }

        $.ajax(chamada2)

       
    })


    $("#provento_anual").on("click", (e) => {
        $("li").removeClass("btn_click")
        $("#provento_anual").addClass("btn_click")
        $("#area_cards_row").html("")
        $("#area_cards_select").html("")
        $("#area_cards_select").append("<div class='col-12 border border-dark'><select id='filtro_provento_anual' class='form-control'><option value=''>Escolha o tipo provento</option><option value='jcp'>juros sobre capital próprio</option><option value='dividendo'>Dividendos</option><option value=ambos>Todos</option></select></div>")


        $("#filtro_provento_anual").on('change', (e) => {
            let val = $(e.target).val()
            console.log(retorno)
            $("#area_cards_row").html('')

            for (i = 0; i < retorno.length; i++) {
                let aux = parseInt(retorno[i].Total)
                let valor = aux.toLocaleString("pt-BR", { style: "currency", currency: "BRL" })

                if (retorno[i].tipo_provento == val) {
                    $("#area_cards_row").append(`<div class="col-auto card  cards_config" ><div class="card-header card-title background_titulo">` + `<strong>${retorno[i].cod}</strong>` + `</div><div class="card-body">` + "<strong>Tipo= </strong>" + retorno[i].tipo_provento + `</div><div class="card-footer">` + "<strong>Total:</strong> " + valor + `</div></div>`)
                } else if (val == "ambos") {
                    $("#area_cards_row").append(`<div class="col-auto card  cards_config" ><div class="card-header card-title background_titulo">` + `<strong>${retorno[i].cod}</strong>` + `</div><div class="card-body">` + "<strong>Tipo= </strong>" + retorno[i].tipo_provento + `</div><div class="card-footer">` + "<strong>Total:</strong> " + valor + `</div></div>`)
                }

            }
            $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
            $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
            $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)

        })

        let chamada3 = {
            url: "backend.php",
            type: "get",
            data: "acao=provento_anual",
            dataType: "json",
            success: (data) => {
                retorno = data

                for (i = 0; i < data.length; i++) {
                    let aux = parseInt(data[i].Total)
                    let valor = aux.toLocaleString("pt-BR", { style: "currency", currency: "BRL" })
                    $("#area_cards_row").append(`<div class="col-auto card  cards_config" ><div class="card-header card-title background_titulo">` + `<strong>${data[i].cod}</strong>` + `</div><div class="card-body">` + "<strong>Tipo= </strong>" + data[i].tipo_provento + `</div><div class="card-footer">` + "<strong>Total:</strong> " + valor + `</div></div>`)

                }
                $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
                $("#area_cards_row" ).append(`<div class='cards_config border-0'><\div>`)
                $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
            }

        }

        $.ajax(chamada3)

    })


    $("#provento_mensal").on("click", (e) => {
        $("li").removeClass("btn_click")
        $("#provento_mensal").addClass("btn_click")
        $("#area_cards_select").html("")
        $("#area_cards_select").append("<div class='col-12 border border-dark'><select id='filtro_provento_mensal' class='form-control'><option value=''>Escolha um mês</option><option value='01'>Janeiro</option><option value='02'>Fevereiro</option><option value=03>Março</option><option value=04>Abril</option><option value=05>Maio</option><option value=06>Junho</option><option value=07>Julho</option><option value=08>Agosto</option><option value=09>Setembro</option><option value=10>Outubro</option><option value=11>Novembro</option><option value=12>Dezembro</option></select></div>")
        $("#area_cards_row").html("")
        $("#filtro_provento_mensal").on("change", (e) => {
            $("#area_cards_row").html("")
            let target = $('#filtro_provento_mensal').val();
            let chamada4 = {
                url: "backend.php",
                type: "get",
                data: "acao=provento_mensal&data=" + target,
                dataType: "json",
                success: (data) => {
                    $("#area_cards_row").html("")
                    for (let i = 0; i < data.length; i++) {
                        let aux = parseInt(data[i].valor_recebido)
                        let valor = aux.toLocaleString("pt-BR", { style: "currency", currency: "BRL" });
                        let dat_brasil = data[i].data_recebido.split('-').reverse().join('/')

                        $("#area_cards_row").append(`<div class="col-auto card  cards_config" ><div class="card-header card-title background_titulo">` + `<strong>${data[i].cod}<\strong>` + `</div><div class="card-body">` + "<strong>Data= </strong>" + dat_brasil + `</div><div class="card-body">` + "<strong>Tipo= </strong>" + data[i].tipo_provento + `</div><div class="card-footer">` + "<strong>Total:</strong> " + valor + `</div></div>`)
                    }
                    $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
                    $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
                    $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)

                }
            }

            $.ajax(chamada4)
        })


    })

    $("#btn_adicionar").on("click",()=>{
    	window.location.href="adicionar_investimento.php"
    })

    $("#fechar").on("click",()=>{
    	$('#div_erro').slideUp('slow')
    	$('#div_sucesso').slideUp('slow')

    })
 

})

function copiar(id){
        
         let textoCopiado = document.getElementById(id);
         textoCopiado.select()
         textoCopiado.setSelectionRange(0,999999)
         document.execCommand('copy')

        }

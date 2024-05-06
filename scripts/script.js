$(document).ready(() => {

    


    $("#todos_ativos").on("click", (e) => {
        $("li").removeClass("btn_click")
        $("#todos_ativos").addClass("btn_click")
        $("#area_cards_row").html("")
        $("#area_cards_select").html("")
        let chamada = {
            url: "scripts/backend.php",
            type: "GET",
            data: "acao=todos_dados",
            dataType: "json",
            success: (data) => {

                $("#area_cards_row").html("")
                for (let i = 0; i < data.length; i++) {
                    let aux = data[i].total_investido
                    let valor = aux.toLocaleString("pt-BR", { style: "currency", currency: "BRL" });


                    $("#area_cards_row").append(`<div class="col-auto card  cards_config" ><div class="card-header card-title background_titulo d-flex justify-content-between">` + `<strong>${data[i].cod.toUpperCase()}</strong> <div><button onclick="adicionarProvento('${data[i].cod.toUpperCase()}')" class="btn btn-sm fa-solid fa-add" ></button><button onClick="deletarAtivo(${data[i].id})" class=" btn btn-sm fa-solid fa-trash text-danger" ></button></div>` + `</div><div class="card-body">` + "<strong>Qtd= </strong>" + data[i].quant + " ações" + `</div><div class="card-footer">` + "<strong>Total:</strong> " + valor + `</div></div>`)

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
            url: "scripts/backend.php",
            type: "get",
            data: "acao=procurar_cnpj",
            dataType: "json",
            success: (data) => {
                $("#area_cards_row").html("")
                for (i = 0; i < data.length; i++) {
                    $("#area_cards_row").append(`<div class="col-auto card  cards_config" ><div class="card-header card-title background_titulo">` + `<strong>${data[i].cod.toUpperCase()}</strong>` + `</div><div class="card-body">` + "<strong>CNPJ:</strong>" + `<input readOnly id='cnpj_copiar_${data[i].cod}' value=${data[i].cnpj} class='form-control text-truncate'>` + `<button onclick="copiar('cnpj_copiar_${data[i].cod}')" class='btn btn-light form-control'><i class="fa-solid fa-copy fa-bounce"></i> <strong>Copiar Cnpj</strong></button>` + `</div><div class="card-footer">` + `</div></div>`)
                }
                $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
                $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
                $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
            }
        }

        $.ajax(chamada2)


    })

    let anual_tipo = ""
    let anual_ano = ""
    $("#provento_anual").on("click", (e) => {
        $("li").removeClass("btn_click")
        $("#provento_anual").addClass("btn_click")
        $("#area_cards_row").html("")
        $("#area_cards_select").html("")
        $("#area_cards_select").append("<div class='col-6 p-0'><select id='filtro_provento_anual_tipo' class='form-control'><option value='' disabled selected>Escolha o tipo provento</option><option value='jcp'>Juros sobre capital próprio</option><option value='dividendo'>Dividendos</option><option value='ambos'>Todos</option></select></div><div class='col-5 p-0'><select id='filtro_provento_anual_ano' class='form-control'><option value='' disabled selected>Escolha um ano</option><option value='2024'>2024</option><option value='2023'>2023</option><option value='2022'>2022</option><option value='2021'>2021</option><option value='2020'>2020</option></select></div><div class='col-1 p-0'><button id='btn_procurar_anual' class='btn btn-secondary w-100'><i  class='fa-solid fa-search fa-pulse'></i></button></div>")

        $("#btn_procurar_anual").on("click", () => {
            anual_tipo = $("#filtro_provento_anual_tipo").val() ?? ''
            anual_ano = $("#filtro_provento_anual_ano").val() ?? ''

            $("#area_cards_row").html('')

            if (anual_tipo !== "" && anual_ano) {
                
                let chamada3 = {
                    url: "scripts/backend.php",
                    type: "get",
                    data: `acao=provento_anual&tipo=${anual_tipo}&ano=${anual_ano}`,
                    dataType: "json",
                    success: (data) => {
                        console.log(data)
                        

                        for (i = 0; i < data.length; i++) {
                            let aux = data[i].Total
                            let valor = aux.toLocaleString("pt-BR", { style: "currency", currency: "BRL" })
                            $("#area_cards_row").append(`<div class="col-auto card  cards_config" ><div class="card-header card-title background_titulo">` + `<strong>${data[i].cod}</strong>` + `</div><div class="card-body">` + "<strong>Tipo= </strong>" + data[i].tipo_provento + `</div><div class="card-footer">` + "<strong>Total:</strong> " + valor + `</div></div>`)

                        }
                        $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
                        $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
                        $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
                    }

                }

                $.ajax(chamada3)

            }




        })
    })

    let mensal_ano = ""
    let mensal_mes = ""
    $("#provento_mensal").on("click", (e) => {
        $("li").removeClass("btn_click")
        $("#provento_mensal").addClass("btn_click")
        $("#area_cards_select").html("")
        $("#area_cards_select").append("<div class='col-6 p-0'><select id='filtro_provento_mensal_mes' class='form-control'><option value='' selected disabled>Escolha um mês</option><option value='01'>Janeiro</option><option value='02'>Fevereiro</option><option value=03>Março</option><option value=04>Abril</option><option value=05>Maio</option><option value=06>Junho</option><option value=07>Julho</option><option value=08>Agosto</option><option value=09>Setembro</option><option value=10>Outubro</option><option value=11>Novembro</option><option value=12>Dezembro</option></select></div><div class='col-5 p-0'><select id='filtro_provento_mensal_ano' class='form-control'><option value='' disabled selected>Escolha um ano</option><option value='2024'>2024</option><option value='2023'>2023</option><option value='2022'>2022</option><option value='2021'>2021</option><option value='2020'>2020</option></select></div><div class='col-1 p-0'><button id='btn_procurar_mensal' class='btn btn-secondary w-100'><i class='fa-solid fa-search fa-pulse'></i></button></div>")
        $("#area_cards_row").html("")

        $("#btn_procurar_mensal").on("click", (e) => {
            mensal_ano = $('#filtro_provento_mensal_ano').val() ?? '';
            mensal_mes = $('#filtro_provento_mensal_mes').val() ?? '';
            if (mensal_ano !== "" && mensal_mes !== "") {
                let dados_mensal = `${mensal_mes}/${mensal_ano}`
                $("#area_cards_row").html("")
                let chamada4 = {
                    url: "scripts/backend.php",
                    type: "get",
                    data: "acao=provento_mensal&data=" + dados_mensal,
                    dataType: "json",
                    success: (data) => {
                        $("#area_cards_row").html("")
                        for (let i = 0; i < data.length; i++) {
                            let aux = data[i].valor_recebido
                            let valor = aux.toLocaleString("pt-BR", { style: "currency", currency: "BRL" });
                            let dat_brasil = data[i].data_recebido.split('-').reverse().join('/')

                            $("#area_cards_row").append(`<div class='col-auto card  cards_config'><div class='card-header card-title background_titulo'><strong>${data[i].cod}</strong></div><div class='card-body'><div><strong>Data= </strong>${dat_brasil}</div><div><strong>Tipo= </strong>${data[i].tipo_provento}</div></div><div class='card-footer'><strong>Total:</strong>${valor}</div></div>`)
                        }
                        $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
                        $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)
                        $("#area_cards_row").append(`<div class='cards_config border-0'><\div>`)

                    }
                }

                $.ajax(chamada4)


            }
        })

    })


    $("#btn_adicionar_ativo").on("click", () => {
        window.location.href = "scripts/adicionar_investimento.php"
    })

    $("#btn_adicionar_provento").on("click", () => {
        window.location.href = "scripts/adicionar_provento.php"
    })

    $("#fechar").on("click", () => {
        $('#div_erro').slideUp('slow')
        $('#div_sucesso').slideUp('slow')

    })

    //mascaras de input
    $('.valor').mask('000.000.000.000.000,00', {reverse: true})
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true})
})
function adicionarProvento(cod) {
    window.location.href = `scripts/adicionar_provento.php?cod=${cod}`
}

function deletarAtivo(id) {
    let deletar = {
        url: "scripts/backend.php",
        type: "post",
        data: `id=${id}`,
        success: (resp) => {
            location.reload()
        }
    }

    $.ajax(deletar)

}

function copiar(id) {

    let textoCopiado = document.getElementById(id);
    textoCopiado.select()
    textoCopiado.setSelectionRange(0, 999999)
    document.execCommand('copy')

}


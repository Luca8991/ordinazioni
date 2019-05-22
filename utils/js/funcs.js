/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    setOrder();

    $('input').click(function(){
        $(this).select();
    });

    $('#order-name').blur(function(){
        var name = $('#order-name').val().trim();
        var table = $('#table-num').text();

        if(name === ''){
            $('#alert').show();
        } else{
            $('#avanti-link').attr('href', '/ordinazioni/ordina.php?n='+name+'&t='+table);
        }
    });

    $('#btn-send').click(function(){
      var order_data = {};
      order_data = JSON.parse(localStorage.getItem('order-data'));
      var order_prods = {}
      order_prods = JSON.parse(localStorage.getItem('order-prods'));

      //console.log(order_data,order_prods);
      if(!$.isEmptyObject(order_data) && !$.isEmptyObject(order_prods)){
        $.post('send.php', {'order-data': order_data, 'order-prods': order_prods}, function(res){

              // show the response
              $('#completed').show();
              $('#completed').html(res);
              //$('#indicazione-gluten').hide();
              $('.indice').hide();
              $('.tabs').hide();
              $('.conto').hide();

          }).fail(function() {

              // just in case posting your form failed
              alert( "C'è stato un errore" );

          });
      }
    });


    $('.tabs input').blur(function(){
        if(!$(this).val().trim()){
            $(this).val('0');
        }

        var idprod = parseInt($(this).attr('data-idprod'),10);
        var qta = parseInt($(this).val(),10);

        updateOrder(idprod,qta);
    });

    $('.tabs textarea').blur(function(){
        setOrds($(this));
    });
});

function setOrder(){
  var ordname = $('#nome-ordine').text();
  var tblnum = parseInt($('#numero-tavolo').text(),10);
  var orderid = parseInt($('#id-ordine').text(),10);

  var newOrderData = {};
  newOrderData = {name: ordname, table: tblnum, idord: orderid};
  localStorage.setItem('order-data', JSON.stringify(newOrderData));

  var newOrderProds = {}
  localStorage.setItem('order-prods', JSON.stringify(newOrderProds));
}

function updateOrder(idprod,qta){
  var order = {}
  order = JSON.parse(localStorage.getItem('order-prods'));

  //console.log(order);
  if((!order[idprod] && qta > 0) || (order[idprod] && qta!==0)){
    order[idprod] = qta;
  }else{
    delete order[idprod];
  }
  localStorage.setItem('order-prods', JSON.stringify(order));
}

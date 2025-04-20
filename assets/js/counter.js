$('.counter-plus').click(function(e){
    let qty = $(e.currentTarget).siblings('#qty');
    let qtyValue = parseInt(qty.val())+1
    if(qtyValue > 100){
        qtyValue = 100
    }
    qty.val
    qty.val(qtyValue)
});

$('.counter-moins').click(function(e){
    let qty = $(e.currentTarget).siblings('#qty');
    let qtyValue = parseInt(qty.val())-1
    if(qtyValue < 0){
        qtyValue = 0
    }
    qty.val(qtyValue)
});
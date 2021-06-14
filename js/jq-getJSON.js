$('#table').append('<div id="rates"></div><div id="reload"></div>');

function loadOrders() {
    $.getJSON('data/tap_offers.json')
    .done( function(data){                                 
    var d = new Date();                                  
    var hrs = d.getHours();                              
    var mins = d.getMinutes();                         
    var msg = '<h2>Beers</h2>';
        
    msg += '<br>' + '<form action="data_collector.php" method="post">';
    
    var temp= 0;
    
    $.each(data.bar.Beer, function(key, val) {
        
    msg += '<div class="select">' + val.beer_name + '</div>';
    msg += '<input type="hidden" title="beer" name="beer' + key + '" value="' + val.beer_name + '" required/>';
    msg += '<input type="hidden" title="price" name="price' + key + '" value="' + val.price + '" required/>';
    msg += '<input type="number" min= "0" max="100" title="quantity" name="quant' + key + '" required/>';
    temp= key;
    });
          
    msg += '<input type="hidden" title="Available beer" name="aval" value="' + temp + '" required/>';    
    msg += '<input type="submit" value="Order" />';
    msg += '</form>' + '<br>';
    
    msg += '<br>Last update: ' + hrs + ':' + mins + '<br>';
    msg += '<br>Total bill: ' + data.total + ' DKK' + '<br>';
    msg += '<br>Splitted bill: ' + data.splitted + ' DKK' + '<br>';
    msg += '<br>Payers: ' + data.payers + '<br>';
    
    $('#rates').html(msg); 

    }).fail( function() {                                 
        $('#rates').text('Sorry, we are closed.');   
    }).always( function() {                                
         
         var reload = '<a id="refresh" href="#">';
         reload += '<img src="img/check_small.png" alt="refresh" /></a>';
         
         $('#reload').html(reload);
         $('#refresh').on('click', function(e) {             
            e.preventDefault();                              
            loadCheckout();                                      
        });
    }); 
}

function loadCheckout() {
    
    $.getJSON('data/tap_offers.json')
    .done( function(data){                                 
    var d = new Date();                                  
    var hrs = d.getHours();                              
    var mins = d.getMinutes();                         
    var msg = '<h2>Checkout</h2>';
    
    msg += '<br>' + '<form method="post" name= "form" action="data_collector.php">';
    
    msg += '<div class="beers">' + 'Set the bill payers' + '</div>';
    msg += '<input type="number" min= "1" title="Quantity" name="payers" id="payers" required/>';
    
    msg += '<input type="submit" value="Modify" />';
    msg += '</form>' + '<br>';
    
    msg += '<br>Last update: ' + hrs + ':' + mins + '<br>';
    msg += '<br>Total bill: ' + data.total + ' DKK' + '<br>';
    msg += '<br>Splitted bill: ' + data.splitted + ' DKK' + '<br>';
    msg += '<br>Payers: ' + data.payers + '<br>';
    
    $('#rates').html(msg); 

    }).fail( function() {                                 
        $('#rates').text('Sorry, we are closed.');   
    }).always( function() {                                
        
        var reload = '<a id="refresh" href="#">'; 
         reload += '<img src="img/back_small.png" alt="refresh" /></a>';          
         reload += '<a id="refresh" href="data_collector.php?end=true"><img id="pay" src="img/payment.png" width="130" height="100" alt="pay"/></a></a>';
         
         $('#reload').html(reload);
         $('#refresh').on('click', function(e) {             
            e.preventDefault();                              
            loadOrders();                                      
        });
    });   
}

loadCheckout();
loadOrders();



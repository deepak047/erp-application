<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Order Details</title>
    
    <style>
    .invoice-box {
        max-width: 1024px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 14px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(6) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(6) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(6) {
        text-align: left;
    }
    .invoice-box-first{
    width: 100%;
    line-height: inherit;
    text-align: left;
}

/* EDIT */
.title-address{
    text-align: right;
}
.subject-pan td{
    padding-top: 30px !important;
    padding-bottom: 30px !important;
    padding-left: 170px !important;
    text-align:center;
    font-size: 18px;
    font-weight: 600;
    text-decoration: underline;
}
.heading td{
    padding-bottom: 10px !important;
    padding-top: 10px !important;
}
.item td{
    padding-bottom: 10px !important;
    padding-top: 10px !important;
}
.item-bill td{
    text-align: left !important;
}
.total .total-left{
    font-weight: bold;
}
.invoice-box table tr.total td:nth-child(6) {
    font-weight: normal;
}
td .total-right{
    text-align: left;
    float: left;
}
td .total-left{
    text-align: left;
}
.en-common-tabl-bottm{
    margin-bottom: 50px;
    margin-top: 50px;
}
.en-common-tabl-bottm ul li{
    padding-bottom: 5px;
    padding-top: 5px;
}


    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0" class="invoice-box-first">
            <tr class="top">
                <td colspan="2">
                    <strong>Order Details - #{{ $order->id }}</strong><br><br>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                  
                </td>
            </tr>

            <tr class="to-address">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                              

                               <strong>Customer Name:</strong> {{ $order->customer_name }},<br>
                               <strong>Customer Email:</strong> {{ $order->customer_email }},<br>
                                <strong>Order Status:</strong> <span class="badge {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($order->status) }}</span>,<br>
                                <strong>Total Amount:</strong> {{ number_format($order->total_amount, 2) }},<br>
                                <strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i A') }}<br>
                            </td>
                            
                            <td>
                                <!-- this left blank -->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            
            
            <tr class="subject-pan">
                <td>
                    Order Items
                </td>
            </tr>
        </table>
        
        <table cellpadding="0" cellspacing="0" class="invoice-box-second">
            <tr class="heading">
                <td> 
                    SI No.
                </td>

                <td>
                    Product Name    
                </td>

               <td>
                     SKU 
                </td>

                <td>
                    Unit Price     
                </td>

                <td>
                     Quantity       
                </td>

                <td style="text-align:left;">
                    Subtotal      
                </td>
            </tr>
            
            

           @forelse ($order->items as $item)
            <tr class="item item-bill">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->product_sku }}</td>
                <td>{{ number_format($item->unit_price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->subtotal, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No items in this order.</td>
            </tr>
        @endforelse
             <tr class="item item-bill">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><span class="total-right">Total:</span></td>
                <td><span class="total-left">{{ number_format($order->total_amount, 2) }}</td>
            </tr>
             
        </table>

        <br>
          <br>
            

      
             <table cellpadding="0" cellspacing="0" class="en-common-tabl-bottm invoice-box-third">
                <tr class="total">
                <td></td>
                
                <td></td>
                <td align ="right" >
                   
                   <span class="total-left">Authorized Signatory</span>
                </td>
            </tr>
        </table>


      

     

        
    </div>
</body>
</html>
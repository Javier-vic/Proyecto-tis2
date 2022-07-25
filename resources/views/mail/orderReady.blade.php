<!DOCTYPE html>
<html lang="en">
<head>
       <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>
    <table role="presentation" style="width:100%;border-collapse:collapse; solid #cccccc;border-spacing:0;text-align:left;">
        
       
        
        <tr>
            <td align="center" style="padding:40px 0 30px 0; margin:0px 0px;" width = "50%" style="height:auto;display:block;">
                
                    
                <table role="presentation" style="width:70%;border-collapse:collapse;text-align:left;">
                    <tr>
                        <td align="center" style="padding:40px 0 30px 0;"width="10%" style="height:100;display:block;">
                            <a href="https://www.facebook.com/ramen.dashi.cl/"><img src="{{ $message->embed(Storage::path("public/img-png/logo.jpg"))}}" width="400" style="height:auto;display:block;border:0;"></a>
                            <h1>Hola {{$cliente->name_order}}  </h1>
                            @if($cliente->order_status == 'Listo')
                                <h3>Queremos infomarte que tu pedido ya se encuentra listo </h3>
                            
                                @elseif ($cliente->order_status == 'Cocinando')
                                    <h3>Queremos infomarte que tu pedido ya esta en preparacion </h3>
                                @else

                            @endif
                         
                            
                            
                        
                        </td>
                    </tr>
                

                    <tr margin-bottom:100px>

                        <td style="padding:30px;background: #ff1717;">
                        
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">

                                <tr>
                            
                                    
                                    <td style="padding:0;width:100%;" align="center">
                                    
                                        
                                       
                                        
                                        <table role="presentation" style="width =100%;border-collapse:collapse;border:0;border-spacing:0;background: #ff1717">

                                            <tr>
                                                
                                                <td>
                                                    <h4>Siguenos en : </h4>
                                                </td>
                                                <td style="padding:0 0 0 10px;width:38px;">
                                                
                                                    <a href="https://www.instagram.com/ramen.dashi/?hl=es"> <img src="{{ $message->embed(Storage::path("public/img-png/instagram.png"))}}" width="38" style="height:auto;display:block;border:0;"></a>
                                                
                                                </td>
                                            
                                                <td style="padding:0 0 0 10px;width:38px;">
                                                
                                                    <a href="https://www.facebook.com/ramen.dashi.cl/"><img src="{{ $message->embed(Storage::path("public/img-png/facebook.png"))}}" width="38" style="height:auto;display:block;border:0;"></a>
                                                
                                                </td>
                                            
                                            </tr>
                                            
                                        </table>

                                    </td>
                                
                                </tr>
                                
                            </table>
                        
                        </td>
                        
                    </tr>
                    
                </table>
                

            
            </td>

            
        </tr>
      
    
    </table>
    
 
  

</body>
</html>
<?php 
  headerAdmin($data); 
//   getModal('modalProductos',$data);
?>
<main class="app-content">
    <div class="app-title">
    <div>
        <h1><i class="fa fa-file-text-o"></i> <?= $data['page_title'] ?></h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>/pedidos"> Pedidos</a></li>
    </ul>
    </div>
    <div class="row">
    <div class="col-md-12">
        <div class="tile">
            <?php 
                if(empty($data['arrPedido'])){
            ?>
            <p>Datos no encontrados.</p>
            <?php
                }else{
                    $cliente = $data['arrPedido']['cliente'];
                    $orden = $data['arrPedido']['orden'];
                    $detalle = $data['arrPedido']['detalle'];
                    $transaccion = $orden['idtransaccionpaypal'] != "" ? $orden['idtransaccionpaypal'] : $orden['referenciacobro'];
            ?>
        <section id="sPedido" class="invoice">
            <div class="row mb-4">
            <div class="col-6">
                <h2 class="page-header"><img width="180px" src="<?= media(); ?>/images/logo.png" ></h2>
            </div>
            <div class="col-6">
                <h5 class="textright">Fecha: <?= $orden['fecha'] ?></h5>
            </div>
            </div>
            <div class="row invoice-info">
            <div class="col-4">
                <address><strong><?= NOMBRE_EMPRESA; ?></strong><br>
                <?= DIRECCION ?><br>
                <?= TELEMPRESA ?><br>
                <?= EMAIL_EMPRESA ?><br>
                <?= WEB_EMPRESA ?>
                </address>
            </div>
            <div class="col-4">
                <address><strong><?= $cliente['nombres'].' '.$cliente['apellidos']; ?></strong><br>
                <b>Envío: </b> <?= $orden['direccion_envio']; ?><br>
                <b>Tel: </b> <?= $cliente['telefono']; ?><br>
                <b>Email: </b> <?= $cliente['email_user']; ?>
                </address>
            </div>
            <div class="col-4"><b>Orden #<?= $orden['idpedido'] ?></b><br>
                <b>Pago: </b> <?= $orden['tipopago'] ?><br>
                <b>Transaccion: </b> <?= $transaccion ?><br>
                <b>Estado: </b> <?= $orden['status'] ?> <br>
                <b>Monto: </b> <?= SMONEY.' '. formatMoney($orden['monto']) ?>
            </div>
            </div>
            <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                <thead>
                    <tr>
                    <th>Descripcion</th>
                    <th class="textright">Precio</th>
                    <th class="textcenter">Cantidad</th>
                    <th class="textright">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $subtotal = 0;
                        if(count($detalle) > 0){
                            foreach($detalle as $producto){
                                $subtotal += $producto['cantidad'] * $producto['precio'];
                    ?>
                    <tr>
                        <td><?= $producto['producto'] ?></td>
                        <td class="textright"><?= SMONEY.' '. formatMoney($producto['precio']) ?></td>
                        <td class="textcenter"><?= $producto['cantidad'] ?></td>
                        <td class="textright"><?= SMONEY.' '. formatMoney($producto['cantidad'] * $producto['precio']) ?></td>
                    </tr>
                    <?php }
                        }  
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="textright">SubTotal:</th>
                        <td class="textright"><?= SMONEY.' '. formatMoney($subtotal) ?></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="textright">Envío:</th>
                        <td class="textright"><?= SMONEY.' '. formatMoney($orden['costo_envio']) ?></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="textright">Total:</th>
                        <td class="textright"><?= SMONEY.' '. formatMoney($orden['monto']) ?></td>
                    </tr>
                </tfoot>
                </table>
            </div>
            </div>
            <div class="row d-print-none mt-2">
            <div class="col-12 textright"><a class="btn btn-primary" href="javascript:window.print('#sPedido');"><i class="fa fa-print"></i> Imprimir</a></div>
            </div>
        </section>
        <?php } ?>
        </div>
    </div>
    </div>
</main>
<?php footerAdmin($data); ?>
<?php headerAdmin($data); ?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> <?= $data['page_title'] ?></h1>
          <p>Start a beautiful journey here</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard">Dashboard</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">Create a beautiful dashboard</div>
          </div>
          <?php
            // $request_api = CurlConnectionGet(URLPAYPAL."/v2/checkout/orders/0U822013YU198821W","application/json", getTokenPaypal());
            // dep($request_api);
            $REQUEST_POST = CurlConnectionPost(URLPAYPAL."/v2/payments/captures/2E194843MS568881R/refund", "application/json", getTokenPaypal());
            dep($REQUEST_POST);
          ?>
        </div>
      </div>
    </main>
<?php footerAdmin($data); ?>
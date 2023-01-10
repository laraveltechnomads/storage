<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <title>{{ config('app.name') }} | @if($lang == 'en') Privacy Policy @elseif($lang == 'zh') 隐私政策 @endif</title>
  <link rel="icon" href="{{ asset('/')}}assets/admin/images/logo/favicon.ico" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/')}}assets/admin/dist/css/adminlte.min.css">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a class="navbar-brand">
        <img src="{{ project('app_logo_path') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{project('app_name')}}</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> Privacy Policy</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            @if($lang == 'zh')
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">歡迎使用本App</h5>

                  <p class="card-text">為了能提供更好的服務品質及提供更優質的使用介面， 我們將在政府許可範圍內合法收集你的設備標識訊息及帳號資訊， 以便本產品為客戶端建立安全的網路環境，及更能有效保護使用者隱私及個人訊息</p>
                  <p class="card-text">我們會嚴格遵守我們的數據安全保密約定，与我們合作的 第三方 廠商也需遵守本公司的相關網路安全保密約定
  本公司收集及處理你個人資料適用於本公司推出的各項科技數據出版課程演講視頻文章論壇商務等所有 活動範圍
  當你使用本APP時使用的網站足跡閱讀文章觀看視頻閱讀時間地點IP均會適時反饋本公司工程部門以便更安全保護您的個人信息讓使用介面更加流暢</p>
                  <p class="card-text">當你使用本APP時我們會依據您的所在地區發送適當的宣傳文宣及廣告我們也會將你的數據瀏覽訊息反饋給我們相關工程部門作為日後使用更優質的網絡瀏覽體驗</p>
                  <p class="card-text">與我們合作的第三方均需配合本公司的網絡安全管理規定您的個人資料依使用人地區管理條例可能略有所不同
                    也為了保護使用者在安全網絡下使用本產品我們對於惡意使用本軟體的使用者我們有權刪除其個人資料並禁止其個人使用本系统</p>
                  <p class="card-text">當你註冊使用本產品同時代表你同意本公司的各種數據管理規定如有異議代表你不能使用本公司產品</p>
                  <p class="card-text">我們會致力於為您的個人資料提供妥善保護並採取適當技術與安全維護措施來保護您的個人資料安全</p>
                  <p class="card-text">本隱私條款可能會依據使用地區國家的法令時間會適時調整與異動我們會統一發布不對個人另行通知使用端需自行閱覽</p>

                </div>
              </div>
            @elseif($lang == 'en')
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Welcome to this App</h5>

                  <p class="card-text">
                  </p>
                </div>
              </div><!-- /.card -->
            @endif
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('/')}}assets/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('/')}}assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('/')}}assets/admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('/')}}assets/admin/dist/js/demo.js"></script>
</body>
</html>

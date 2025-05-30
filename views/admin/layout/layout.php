<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Hỏi Dân IT - Dự án laptopshop" />
    <meta name="author" content="Hỏi Dân IT" />
    <title>Dashboard - Hỏi Dân IT</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/shoeimportsystem/views/admin/layout/css/styles.css">
    <link rel="stylesheet" href="/shoeimportsystem/views/admin/style.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  </head>

  <body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
      <a class="navbar-brand ps-3" href="index.html">Quản lý bán giày</a>
      <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
      </button>
      <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <span style="color: white">Welcome, Admin</span>
      </form>
      <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user fa-fw"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#!">Settings</a></li>
            <li><hr class="dropdown-divider" /></li>
            <li><a class="dropdown-item" href="#!">Logout</a></li>
          </ul>
        </li>
      </ul>
    </nav>
    <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
          <div class="sb-sidenav-menu">
            <div class="nav">
              <div class="sb-sidenav-menu-heading" style="margin-left: 53px; font-size: 16px;">MENU</div>
              <!-- Sidebar -->
              <?php include __DIR__ . '/sidebar.php'; ?>
              <!-- End Sidebar -->
              <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion"></div>
            </div>
          </div>
          <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Hỏi Dân IT
          </div>
        </nav>
      </div>
      <div id="layoutSidenav_content">
        <main>
          <div class="content" id="content-area">
            <?php 
              if (isset($content_file)) {
                  include $content_file;
              } else {
                  echo "<h1>Chào mừng đến với Admin</h1>";
              }
            ?>
          </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
          <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
              <div class="text-muted">Copyright © Shop bán giày 2025</div>
              <div>
                <a href="" target="_blank">Website</a> &middot; 
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/shoeimportsystem/views/admin/layout/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="/shoeimportsystem/views/admin/layout/assets/demo/chart-area-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="/shoeimportsystem/views/admin/layout/js/datatables-simple-demo.js"></script>
    <script>
      // Xử lý sự kiện nhấp vào liên kết trong sidebar
      document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault(); // Ngăn reload trang
          const url = this.getAttribute('href');

          fetch(url)
            .then(response => response.text())
            .then(html => {
              const parser = new DOMParser();
              const doc = parser.parseFromString(html, 'text/html');
              const content = doc.querySelector('.content').innerHTML; // Lấy nội dung từ .content
              document.getElementById('content-area').innerHTML = content; // Cập nhật nội dung
            })
            .catch(error => {
              console.error('Error loading content:', error);
              document.getElementById('content-area').innerHTML = '<p style="color:red;">Lỗi tải dữ liệu!</p>';
            });
        });
      });
    </script>
  </body>
</html>
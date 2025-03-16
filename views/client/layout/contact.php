<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ</title>
    <link href="/shoeimportsystem/views/client/layout/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include("header.php"); ?>
    <div class="contact-container">
        <div class="contact-form">
            <h2>Liên hệ</h2>
            <form action="#" method="post">
                <div class="form-group">
                    <label for="ho">Họ</label>
                    <input type="text" id="ho" name="ho">
                </div>
                <div class="form-group">
                    <label for="ten">Tên</label>
                    <input type="text" id="ten" name="ten">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="tieu-de">Tiêu đề</label>
                    <input type="text" id="tieu-de" name="tieu-de">
                </div>
                <div class="form-group">
                    <label for="noi-dung">Nội dung</label>
                    <textarea id="noi-dung" name="noi-dung"></textarea>
                </div>
                <button type="submit">Gửi</button>
            </form>
        </div>
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.6521522291517!2d106.68005371473215!3d10.761356592334237!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f1b131139a1%3A0xb36994c92a627a9f!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBTxrAgcGjhuqltIEPDtG5nIG5naOG7hyBUUC5IQ00!5e0!3m2!1svi!2s!4v1678887532845!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>
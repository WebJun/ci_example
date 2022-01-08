

<!DOCTYPE html>
<html lang='ko'>
<head>
<title>인스타모아</title>
<link rel='icon' href='https://www.instagrammoa.com/static/img/36b3ee2d91ed.ico'>

<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<meta name='title' content='인스타모아'>
<meta name='keywords' content='인스타,인스타그램,다운로더,백업,이미지,원본,모아보기,검색,인스타백업,인스타이미지,인스타원본,인스타모아보기,인스타검색,인스타다운로더'>
<meta name='author' content='Jun'>
<meta name='description' content='인스타모아'>
<meta name='robots' content='index,follow'>

<meta property='og:locale' content='ko_KR' />
<meta property='og:type' content='website'>
<meta property='og:title' content='인스타모아'>
<meta property='og:description' content='인스타모아'>
<meta property='og:image' content=''>
<meta property='og:url' content='https://www.instagrammoa.com/'>
<meta property='og:site_name' content='instamoa' />

<link rel='icon' sizes='192x192' href='https://www.instagrammoa.com/static/img/68d99ba29cc8.png'>
<link rel='mask-icon' href='https://www.instagrammoa.com/static/img/fc72dd4bfde8.svg' color='#262626'>
<link rel='shortcut icon' type='image/x-icon' href='https://www.instagrammoa.com/static/img/36b3ee2d91ed.ico'>

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css'/>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css'/>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css'/>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css'/>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/themes/bootstrap.min.css'/>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'/>
<link rel='stylesheet' type='text/css' href='https://cdn.jsdelivr.net/gh/moonspam/NanumBarunGothic@latest/nanumbarungothicsubset.css'>
<link rel='stylesheet' href='https://www.instagrammoa.com/static/css/moa.css?210824'/>
</head>
<body>

<style>
table thead td {font-weight:bold;}
</style>

<div class="container" style="margin-top:30px;">
    <table class="table table-striped">
        <thead>
            <tr>
                <td>seq</td>
                <td>title</td>
                <td>content</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?=$item['seq']?></td>
                <td><?=$item['title']?></td>
                <td><?=$item['content']?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>



    
    <div style="text-align:center;">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" href="/?page=<?=$pages['p']?>">
                    Previous
                </a>
            </li>

            <?php for ($i = $pages['s']; $i <= $pages['e']; $i++ ): ?>
                <li class="page-item <?php if ($pages['c'] === $i) echo 'active' ;?>">
                    <a class="page-link" href="/?page=<?=$i?>">
                        <?=$i?>
                    </a>
                </li>
            <?php endfor ?>

            <li class="page-item">
                <a class="page-link" href="/?page=<?=$pages['n']?>">
                    Next
                </a>
            </li>
        </ul>
    </div>

    <div style="text-align:right; margin-top:10px; ">
        <a href="<?=BASE_URL?>/main/add">
            <button class="btn btn-sm btn-success">글쓰기</button>
        </a>
    </div>
</div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/i18n/ko.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.10/jquery.lazy.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/smoothscroll/1.4.10/SmoothScroll.min.js'></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
<script src='https://www.instagrammoa.com/static/js/common.js?210804'></script>
</body>
</html>

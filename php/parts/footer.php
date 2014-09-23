</main>
<link rel="stylesheet" href="/css/parts/footer.css">
<footer class="footer">
    <div class="footer__ribbon"></div>
    <p class="footer__copyright">&copy; 2014 643.ru</p>
    <p class="footer__credits">
        ГБОУ школа № 643<br>
        Тел: +7 (812) 111-00-00
    </p>
    <p class="footer__login-logout">
        <? if (isLoggedIn()) { ?>
            <a href="/php/pages/auth/logout.php">Выход из админстрирования</a>
        <? } ?>
    </p>
</footer>
</body>
</html>

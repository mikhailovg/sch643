</main>
<link rel="stylesheet" href="/css/parts/footer.css">
<footer class="footer">
    <div class="footer__ribbon"></div>
    <p class="footer__copyright">&copy; 2014 setomaa.com</p>
    <p class="footer__credits">
        Печерская районная общественная организация<br>
        «Этнокультурное общество Сето»<br>
        Тел: +7 (8112) 98-76-34
    </p>
    <p class="footer__login-logout">
        <? if (isLoggedIn()) { ?>
            <a href="/logout">Выход из админстрирования</a>
        <? } ?>

    </p>
</footer>
</body>
</html>
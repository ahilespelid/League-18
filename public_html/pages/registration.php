<div class="Registration">
    <div class="Info">Перед созданием нового персонажа, Вам необходимо ознакомиться с <a href="/?route=rules" target="_blank">правилами игры</a>. Нажимая на кнопку "Создать персонажа", вы автоматически соглашаетесь с правилами.</div>
    <div class="Inputs">
      <form>
        <div class="Step">
          <label>Имя персонажа</label>
          <input type="text" id="regLogin" placeholder="Имя персонажа">
          <div class="Sub">Придумайте имя для своего персонажа. Используйте свою фантазию!</div>
        </div>
        <div class="Step">
          <label>Пароль</label>
          <input type="password" id="regPass" placeholder="Пароль">
          <div class="Sub">Придумайте пароль.</div>
        </div>
        <div class="Step">
          <label>Повтор пароля</label>
          <input type="password" id="regDblPass" placeholder="Пароль еще раз">
          <div class="Sub">Повторите свой пароль, чтобы избежать ошибок.</div>
        </div>
        <div class="Step">
          <label>Электронная почта</label>
          <input type="text"  id="regMail" placeholder="Электронная почта">
          <div class="Sub">Введите свою электронную почту. Она будет использоваться для восстановления доступа к аккаунту.</div>
        </div>
        <div class="Step">
          <div class="Gender">
            <a class="Arrow" onclick="editGender();">«</a><span id="GenderDiv" data-patch="0" onclick="editGender();">Пол</span><a class="Arrow" onclick="editGender();">»</a>
          </div>
          <div class="Head">
            Внешность аватара можно будет изменять в игровом мире.
          </div>
        </div>
        <div class="GoReg" onclick="registration()">Создать персонажа</div>
      </form>
    </div>
    <div class="Avatar" style="display: none;">
      <div class="AvatarConstruct" style="background-image: url(https://static1.squarespace.com/static/55947ac3e4b0fa882882cd65/58ab7d7229687f223f18a4d4/58ab9a90f7e0ab024bc506f5/1487641285336/NS_0036.png);">
        <!-- Тут img разные стили -->
      </div>
    </div>
  </div>

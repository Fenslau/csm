<form class="" name="login" action="{{ route('login') }}" method="post">
@csrf
<div class="modal fade" id="login" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-key"></i> Войти в систему</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="form-group">
          <label for="login">Логин: </label>
          <input name="login" class="form-control form-control-sm" id="login">
        </div>

        <div class="form-group">
          <label for="password">Пароль: </label>
          <input name="password" class="form-control form-control-sm" id="password" type="password">
        </div>

      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in fa-flip-horizontal"></i>&nbsp;Войти</button>
        </div>
      </div>
    </div>
  </div>
  </form>

<h1>Alterar Senha</h1>

<form action="index.php?controller=User&action=updatePassword&id=<?= $user->getId() ?>" method="post">

   <div class="form-group">
    <label>Senha Atual</label>
    <input type="password" name="currentPassword" class="form-control"  placeholder="Senha Atual">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label >Nova Senha</label>
    <input type="password" name="newPassword" class="form-control" placeholder="Nova Senha">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label>Confirme a Senha</label>
    <input type="password" name="confirmPassword" class="form-control" placeholder="Confirme a Senha">
  </div>
  <button type="submit" name="save" class="btn btn-primary">Submit</button>
</form>

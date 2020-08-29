<h1>Listar Usuários</h1>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Opções</th>
    </tr>
  </thead>
  <tbody>

  <?php 
    
    if($users) :
    
      foreach ($users as $user) :?>
        
        <tr>
          <td scope="row"><?php echo $user->getId() ?></td>
          <td><a href="#"><?= $user->getName() ?></a></td>
          <td><?=  $user->getEmail() ?></td>
          <td>
           	<a href="index.php?controller=User&action=update&id=<?= $user->getId()?>" class="btn btn-primary btn-sm" role="button">Editar</a>
            <a href="index.php?controller=User&action=delete&id=<?= $user->getId()?>" class="btn btn-danger btn-sm" role="button">Excluir</a>
            <a href="index.php?controller=User&action=updatePassword&id=<?= $user->getId()?>" class="btn btn-info btn-sm" role="button">Alterar Senha</a>
          	<span id="active-<?= $user->getId()?>">
          		<a href="#" onClick="activate(<?= $user->getId() ?>)" class="btn btn-<?= $user->getActive() == '1' ? 'danger' : 'success' ?> btn-sm" role="button"><?= $user->getActive() == '1' ? 'Desativar' : 'Ativar' ?></a>
			</span>
          </td>
        </tr>
      <?php 

      endforeach; 
   endif;

  ?>    
  </tbody>
</table>

<script>
	function activate(id)
	{
		$.ajax({url: "index.php?controller=User&action=activate&id="+id, success: function(result){
			
			$("#active-"+id).html(result);
		}});
	}
</script>

<?php $results['pageTitle'] = "Livros | Tenda Pai Benedito";
include "templates/include/header.php" ?>

      <ul class="col-sm-12" id="headlines">

		<!-- Blog Post -->
		  <br>
		  <br>
          <div class="card mb-4">
            <div class="card-body col-sm-12">
              <h2 class="card-title">Leitura Indicada</h2>
              <div class="table-responsive">
              <table class="table col-sm-12">
				<thead>
					<tr>
					<th scope="col">ISBN</th>
					<th scope="col">Nome do Livro</th>
					<th scope="col">Autor Espiritual</th>
					<th scope="col">Medium</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $results4['book'] as $books ) { ?>
						<tr>
							<th scope="row"><a href="<?php echo $books->bookLink?>" target="_blank" class="btn"><?php echo $books->ISBN?></a></th>
							<td><?php echo $books->bookTitle?></td>
							<td><?php echo $books->bookAuthor?></td>
							<td><?php echo $books->bookMedium?></td>
						</tr>
					<?php } ?>
				</tbody>
				</table>
              </div>
            </div>
          </div>
      </ul>


<?php include "templates/include/footer.php" ?>

	
<?php $NUM_ARTICLES = 5;
$current_page = 1;
  if ( isset( $_GET['pageNumber'] ) ) {
	$current_page = $_GET['pageNumber'];
    $data = Article::getList( ($current_page)*$NUM_ARTICLES, "id DESC" );
  }
	$secondary_info = Article::getList();
	$num_pages = (int)$secondary_info['totalRows']/$NUM_ARTICLES;
	if($secondary_info['totalRows']%$NUM_ARTICLES != 0)
	{
		$num_pages++;
	}
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
include "templates/include/header.php"; ?>

<br>
<br>
<h1>Todos os Artigos.</h1>
<p><?php echo $results['totalRows']?> artigo<?php echo ( $results['totalRows'] != 1 ) ? 's' : '' ?> no total.</p>

<div class="list-group">
	<?php foreach ( $results['articles'] as $article ) { ?>
		<?php if(($article->id <= $results['totalRows']-($NUM_ARTICLES*($current_page-1))) && ($article->id > ($results['totalRows']-($NUM_ARTICLES*($current_page-1)))-$NUM_ARTICLES)){?>
		<a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>" class="list-group-item list-group-item-action flex-column align-items-start">
			<div class="d-flex w-100 justify-content-between">
				<h5 class="mb-1"><?php echo htmlspecialchars( $article->title )?></h5>
				<small><?php echo strftime('%d/%m/%G', $article->publicationDate)?></small>
			</div>
			<p class="summary"><?php echo strip_tags(htmlspecialchars_decode( $article->summary ))?></p>
		</a>
		<?php } ?>
	<?php } ?>
</div>
<br>
<nav aria-label="Page navigation">
  <ul class="pagination">
	<?php if ($current_page != 1) { ?>
    <li class="page-item">
      <a class="page-link" href="./?action=archive&pageNumber=<?php echo $current_page-1;?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
	<?php } ?>
	<?php for($i = 1; $i <= $num_pages; $i++){?>
		<?php if ( $_GET['pageNumber'] == $i ) { ?>
			<li class="page-item active"><a class="page-link"><?php echo $i ?></a></li>
		<?php }else { ?>
			<li class="page-item"><a class="page-link" href="./?action=archive&pageNumber=<?php echo $i;?>"><?php echo $i ?></a></li>
		<?php } ?>
	<?php } ?>
	<?php if ($current_page != floor($num_pages)) {?>
    <li class="page-item">
      <a class="page-link" href="./?action=archive&pageNumber=<?php echo $current_page+1;?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
	<?php } ?>
  </ul>
</nav>
<p><a href="./">Retornar à página inicial</a></p>

<?php include "templates/include/footer.php" ?>
<?php include "templates/include/header.php"; ?>

<br>
<br>
<?php if($_SESSION['accesslevel'] == 1)
		include "templates/include/adminHeader.php"; 
	  elseif ($_SESSION['accesslevel'] == 2)
		include "templates/include/adminHeader_2.php"?>

<?php if ( isset( $results['errorMessage'] ) ) { ?>		
	<div class="alert alert-danger" role="alert">
		<?php echo $results['errorMessage'] ?>
			
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php } ?>


<?php if ( isset( $results['statusMessage'] ) ) { ?>		
	<div class="alert alert-warning" role="alert">
		<?php echo $results['statusMessage'] ?>
			
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php } ?>

<?php if($_SESSION['accesslevel'] == 1){ ?>
<h1>Notícias</h1>
<div class="list-group" style="height: 200px;overflow-y: scroll;">
	<?php foreach ( $results3['news'] as $news ) { ?>
		<a onclick="location='admin.php?action=editNews&amp;newsID=<?php echo $news->newsID?>'" class="list-group-item list-group-item-action flex-column align-items-start">
			<div class="d-flex w-100 justify-content-between">
				<?php if($news->title == "") { ?>
					<h5 class="mb-1">Sem título - ID: <?php echo $news->newsID?></h5>
				<?php }else { ?>
					<h5 class="mb-1"><?php echo $news->title?></h5>
				<?php } ?>
				
				<?php if($news->content == "") { ?>
					<small>Sem texto - ID: <?php echo $news->newsID?></small>
				<?php }else { ?>
					<small><?php echo $news->content?></small>
				<?php } ?>
					
			</div>
		</a>
	<?php } ?>
</div>
<br>

<h1>Cursos</h1>
<div class="list-group" style="height: 200px;overflow-y: scroll;">
	<?php foreach ( $results2['courses'] as $courses ) { ?>
		<a onclick="location='admin.php?action=editCourses&amp;courseID=<?php echo $courses->courseID?>'" class="list-group-item list-group-item-action flex-column align-items-start">
			<div class="d-flex w-100 justify-content-between">
				<?php if($courses->courseStatus === 3) { ?>
					<h5 class="mb-1"><i class="fas fa-ban" style="color: red"/></i> <?php echo $courses->courseName?></h5>
				<?php } elseif($courses->courseStatus === 2) { ?>
					<h5 class="mb-1"><i class="fas fa-walking" style="color: yellow"/></i> <?php echo $courses->courseName?></h5>
				<?php } elseif($courses->courseStatus === 1) { ?>
					<h5 class="mb-1"><i class="fas fa-thumbs-up" style="color: green"/></i> <?php echo $courses->courseName?></h5>
				<?php } ?>
				<small><?php echo strftime('%d/%m/%G', $courses->courseStartDate)?></small>
			</div>
		</a>
	<?php } ?>
</div>
<br>

<h1>Livros</h1>
<div class="list-group" style="height: 200px;overflow-y: scroll;">
	<?php foreach ( $results4['book'] as $books ) { ?>
		<a onclick="location='admin.php?action=editBooks&amp;bookID=<?php echo $books->bookID?>'" class="list-group-item list-group-item-action flex-column align-items-start">
			<div class="d-flex w-100 justify-content-between">
				<h5 class="mb-1"><?php echo $books->bookTitle?></h5>
				<small><?php echo $books->bookMedium?></small>
			</div>
		</a>
	<?php } ?>
</div>
<br>
<?php } ?>

<h1>Artigos</h1>
<div class="list-group"style="height: 200px;overflow-y: scroll;">
	<?php foreach ( $results['articles'] as $article ) { ?>
		<a onclick="location='admin.php?action=editArticle&amp;articleId=<?php echo $article->id?>'" class="list-group-item list-group-item-action flex-column align-items-start">
			<div class="d-flex w-100 justify-content-between">
				<h5 class="mb-1"><?php echo $article->title?></h5>
				<small><?php echo strftime('%d/%m/%G', $article->publicationDate)?></small>
			</div>
		</a>
	<?php } ?>
</div>
<br>

<?php include "templates/include/footer.php" ?>
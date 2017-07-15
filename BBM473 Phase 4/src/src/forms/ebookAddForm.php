<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ebook Add</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/semantic.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-serialize-object/2.5.0/jquery.serialize-object.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/semantic.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>
</head>
<body>
	<div class="ui container">
		<div class="ui text container" style="padding: 50px; size: 200px;">
			<h1 class="ui header" style="text-align: center">Ebook Add</h1>
			<form id="ebook-info-form" action="register.php" method="post" class="ui form">
				<div class="field">
				<label>Book Size</label>
					<input type="text" name="book-size" placeholder="File Size">
				</div>
				<div class="field">
					<label>Book Language</label>
					<input type="password" name="book-language" placeholder="Language">
				</div>
				<div class="field">
					<label>Page Number</label>
					<input type="text" name="page-number" placeholder="Page Number">
				</div>
				<div class="field">
					<label>Book ID</label>
					<input type="text" name="book-id" placeholder="Book ID">
				</div>
				<div class="field">
					<label>Publisher ID</label>
					<input type="text" name="publisher-id" placeholder="Publisher ID">
				</div>
				<div class="field">
					<label>Insert User</label>
					<input type="text" name="insert-user" placeholder="Insert User">
				</div>
				<div class="field">
					<label>Last Update User</label>
					<input type="text" name="last-update-user" placeholder="Last Update User">
				</div>
				<div class="field">
					<label>Insert Date</label>
					<input type="text" name="insert-date" placeholder="Insert Date">
				</div>
				<div class="field">
					<label>Last Update Date</label>
					<input type="text" name="last-update-date" placeholder="Last Update Date">
				</div>
				<div class="field">
					<label>Publish Date</label>
					<input type="text" name="publish-date" placeholder="Publish Date">
				</div>
				<div class="field">
					<label>Ebook File</label>
					<input type="text" name="ebook-file" placeholder="Ebook File">
				</div>
				</div>
			</form>
			<div class="actions">
            <div style="text-align: center">
                <input type="submit" id="add-ebook" class="ui blue button" value="Add Book"/>
            </div>
        </div>
		</div>
	</div>
</body>
</html>
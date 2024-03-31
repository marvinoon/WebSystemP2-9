<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/main.css">
    <?php
    include "inc/head.inc.php"
    ?>
</head>

<body>
    <?php
    include "inc/nav.inc.php";
    ?>

    <header class="S1">
        <div class="heading">
            <h1 id="headline">Welcome to eBookify!</h1>
            <img id="header" class="img-fluid" src="images/books.jpg" />
        </div>
    </header>
    <main>
        <section class="featured-books">
            <div class="featured-container">
                <h2 class="text-center mb-4">Books</h2>
                <div class="text-center">
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Book (modal)</button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Title:</label>
                                            <input type="text" class="form-control" id="field-title">
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Description:</label>
                                            <textarea class="form-control" id="field-description"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Image:</label>
                                            <input type="text" class="form-control" id="field-image"></input>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="row books-container flex-nowrap overflow-auto">
                    <!-- Book 1 -->
                    <div class="col-3">
                        <div class="card">
                            <img src="images/Example Book.png" class="card-img-top" alt="Book 1">
                            <div class="card-body">
                                <h5 class="card-title">Book Title 1</h5>
                                <p class="card-text">Book 1 description...</p>
                                <button type="button" class="btn btn-warning">Modify</button>
                                <button type="button" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                    <!-- Book 2 -->
                    <div class="col-3">
                        <div class="card">
                            <img src="images/Example Book.png" class="card-img-top" alt="Book 2">
                            <div class="card-body">
                                <h5 class="card-title">Book Title 2</h5>
                                <p class="card-text">Book 2 description...</p>
                                <button type="button" class="btn btn-warning">Modify</button>
                                <button type="button" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <img src="images/Example Book.png" class="card-img-top" alt="Book 3">
                            <div class="card-body">
                                <h5 class="card-title">Book Title 3</h5>
                                <p class="card-text">Book 3 description...</p>
                                <button type="button" class="btn btn-warning">Modify</button>
                                <button type="button" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <img src="images/Example Book.png" class="card-img-top" alt="Book 4">
                            <div class="card-body">
                                <h5 class="card-title">Book Title 4</h5>
                                <p class="card-text">Book 4 description...</p>
                                <button type="button" class="btn btn-warning">Modify</button>
                                <button type="button" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <img src="images/Example Book.png" class="card-img-top" alt="Book 5">
                            <div class="card-body">
                                <h5 class="card-title">Book Title 5</h5>
                                <p class="card-text">Book 5 description...</p>
                                <button type="button" class="btn btn-warning">Modify</button>
                                <button type="button" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <img src="images/Example Book.png" class="card-img-top" alt="Book 6">
                            <div class="card-body">
                                <h5 class="card-title">Book Title 6</h5>
                                <p class="card-text">Book 6 description...</p>
                                <button type="button" class="btn btn-warning">Modify</button>
                                <button type="button" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section style="text-align: center; font-size: larger; font-weight: bold; color: black;">
            Placeholder Section
        </section>
    </main>

    <?php
    include "inc/footer.inc.php";
    ?>
</body>

</html>
<?php
    include('database.php');

    if (!isset($_POST['search'])){
        $search = "";
    }
    else{
        $search = $_POST['search'];
    }

    $queryHalf = "FROM Product WHERE name like '%$search%'";

    $department = @$_POST['department'];
    if ($department != 0){
        $queryHalf .= " AND departmentID = '$department'";  
    }

    $price_range = @$_POST['price-range'];
    if ($price_range == "<10"){
        $queryHalf .= " AND price < 10";
    }
    else if ($price_range == "10-25"){
        $queryHalf .= " AND price BETWEEN 10 AND 25";
    }
    else if ($price_range == "25>"){
        $queryHalf .= " AND price > 25";
    }

    $query = "SELECT count(*) ".$queryHalf;
    $results = $db->query($query);
    $count = $results->fetch();

    $query = "SELECT * ".$queryHalf;
    $results = $db->query($query);
?>

<html lang="en" id="searchHTML">
    <head>
        <meta charset="UTF-8">
        <title>NED's Grocery</title>
        <link rel="shortcut icon" href="images/favicon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="slider.css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body id="searchBody">
        <form method="POST">
            <header>
                <nav id="searchNav">
                    <div id="mySidenav" class="sidenav">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        <p>Categories</p>
                        <a href="#">Fruit</a>
                        <a href="#">Vegetables</a>
                        <a href="#">Meat</a>
                        <a href="#">Seafood</a>
                        <a href="#">Dairy and Eggs</a>
                    </div>
                    <span id="menuButton" onclick="openNav()">&#9776;</span>
                    <a href="home.php"><img id="logo" src="images/logo.png"></a>
                    <div id="searchForm">
                        <input id="searchBar" type=text placeholder="Search Products" name="search">
                        <button id="searchButton" type=submit><i class="fa fa-search"></i></button>
                    </div>
                    <div id="accountBox">
                        <a id="accountLink" href="account.html"><image id="accountIcon" src="images/accountIcon.png"></image>Account</a>
                    </div>
                    <div id="cartBox">
                        <a id="cartLink" href="cart.html"><image id="cartIcon" src="images/shoppingCartIcon.png"></image>Shopping Cart</a>
                    </div>
                </nav>
            </header>
            <main id="searchMain">
                <div id="sideBar">
                    <p id="filter">Filter Results</p>
                    <p class="filterCategory">Department</p>
                    <form id="form2" method="POST">
                        <ul id="filterList">
                            <li>
                                <input type="radio" value="0" name="department" checked>
                                <label>None</label>
                            </li>
                            <li>
                                <input type="radio" value="1" name="department">
                                <label>Fruit</label>
                            </li>
                            <li>
                                <input type="radio" value="2" name="department">
                                <label>Vegetables</label>
                            </li>
                            <li>
                                <input type="radio" value="3" name="department">
                                <label>Meat</label>
                            </li>
                            <li>
                                <input type="radio" value="4" name="department">
                                <label>Seafood</label>
                            </li>
                            <li>
                                <input type="radio" value="5" name="department">
                                <label>Dairy and Eggs</label>
                            </li>
                        </ul>
                        <p class="filterCategory">Price Range</p>
                        <ul id="filterList">
                            <li>
                                <input type="radio" value="0" name="price-range" checked>
                                <label>None</label>
                            </li>
                            <li>
                                <input type="radio" value="<10" name="price-range">
                                <label>Less than $10</label>
                            </li>
                            <li>
                                <input type="radio" value="10-25" name="price-range">
                                <label>$10 - $25</label>
                            </li>
                            <li>
                                <input type="radio" value="25>" name="price-range">
                                <label>$25+</label>
                            </li>
                        </ul>
                        <p class="filterCategory">Other</p>
                        <ul id="filterList">
                            <li>
                                <input type="checkbox" value="on-sale" name="other">
                                <label>On-Sale</label>
                            </li>
                            <li>
                                <input type="checkbox" value="holiday" name="other">
                                <label>Holiday</label>
                            </li>
                            <li>
                                <input type="checkbox" value="perishable" name="other">
                                <label>Perishable</label>
                            </li>
                            <li>
                                <a href="search.php"><img id="refresh" src="images/refresh.png"></a>
                            </li>
                        </ul>
                    </form>
                </div>
                <div id="results">
                    <p id="resultsCount">
                        <?php 
                            if ($search == ''){
                                echo "Select items to add to your cart";
                            }
                            else{
                                echo $count['count(*)']." Search Results for '".$search."'";
                            }
                        ?>
                    </p>
                    <table id="resultsTable">
                        <form>
                            <?php
                            $i = 0;
                            foreach($results as $product):
                                if ($i % 3 == 0){
                                    echo "<tr>";
                                }
                            ?>
                                <td>
                                    <div class="item">
                                        <img class="itemPic" src="<?php echo $product['imgLink'];?>">
                                        <p class="itemPrice">$<?php echo $product['price']?></p>
                                        <p class="itemDescription"><?php echo $product['name']?></p>
                                        <button class="addToCart" type=submit>Add to Cart</button>
                                    </div>
                                </td>
                            <?php
                            $i++;
                            if ($i % 3 == 0){
                                echo "</tr>";
                            } endforeach;?>
                        </form>
                    </table>
                </div>
            </main>
        </form>
    </body>
    <footer id="searchFooter">
        <p>&copy; 2020 NED's Grocery</p>
    </footer>
    <script src="index.js"></script>  
</html>
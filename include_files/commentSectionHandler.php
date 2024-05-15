<?php
    require_once 'dbs.php';

    if (isset($_POST['article'])
        && isset($_POST['limit'])
        && isset($_POST['sortType'])) sortComments($_POST['article'], $_POST['limit'], $_POST['sortType']);

    else if (isset($_POST['commID'])) dispCommentBody($_POST['commID']);

    else if (isset($_POST['article'])
        && isset($_POST['limit'])) displayComments($_POST['article'], $_POST['limit']);

    else return;

    function displayComments($sp_id, $limit) {
        $conn = connectDbs();

        if ($conn -> connect_errno) {
            echo "Failed to connect to MySQL: " . $conn -> connect_error;
            exit();
        }

        $sql = "SELECT *, recenzie.id as 'idcko'
                FROM recenzie 
                JOIN dotaznik d on recenzie.id = d.recenzia_ID
                WHERE recenzie.studijny_program_ID=? AND d.otazka_ID = 11
                ORDER BY datum_pridania_recenzie DESC
                LIMIT $limit";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $sp_id);
        $stmt->execute();
        $result = $stmt->get_result();

        echoComments($sp_id, $conn, $result);
    }

    function echoComments($sp_id, $conn, $result) {

        if ($result->num_rows == 0 ) {
            echo <<<EOP
            <script>
                document.getElementById("sortButts").style.display = "none";
            </script>
EOP;
        }

        while ($comment = $result->fetch_array(MYSQLI_ASSOC)) {
            $id = $comment['idcko'];
            $autor = $comment['autor'];
            $datum = $comment['datum_pridania_recenzie'];
            $ukazka = Nl2br($comment['odpoved']);
            $divId = "commBody" . $id;
            $buttId = "commButt" . $id;

            if (empty($ukazka)) {
                $sql = "SELECT *
                        FROM recenzie 
                        JOIN dotaznik d on recenzie.id = d.recenzia_ID
                        WHERE recenzie.studijny_program_ID=? AND recenzia_ID=? AND d.otazka_ID = 3";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ii', $sp_id, $id);
                $stmt->execute();
                $resultt = $stmt->get_result();
                $comm = $resultt->fetch_array(MYSQLI_ASSOC);
                $ukazka = Nl2br($comm['odpoved']);
            }

            echo <<<EOP
                        <div class="comment-box my-2 mb-4" onclick="showCommentBody($id)">
                            <h5 class="comment-autor"> 
                                <small class="d-flex justify-content-end comment-date"> $datum</small>
                                $autor 
                            </h5>
                            
                            <div class="comment-box-ukazka mx-1">
                                $ukazka
                            </div>
                            
                            <div id=$divId class="comment-box-body mx-1" style="display: none"></div>
                            
                            <small id=$buttId class="d-flex justify-content-start mx-1 mt-3 citat-viac"> ... čítať viac</small>
                        </div>
                   EOP;
        }
    }

    function sortComments($sp_id, $limit, $sortType) {

        $conn = connectDbs();

        if ($conn -> connect_errno) {
            echo "Failed to connect to MySQL: " . $conn -> connect_error;
            exit();
        }

        if ($sortType == "down") {
            $sql = "SELECT *, recenzie.id as 'idcko'
                    FROM recenzie 
                    JOIN dotaznik d on recenzie.id = d.recenzia_ID
                    WHERE recenzie.studijny_program_ID=? AND d.otazka_ID = 11 
                    ORDER BY datum_pridania_recenzie DESC
                    LIMIT $limit";
        }
        else {
            $sql = "SELECT *, recenzie.id as 'idcko'
                    FROM recenzie 
                    JOIN dotaznik d on recenzie.id = d.recenzia_ID
                    WHERE recenzie.studijny_program_ID=? AND d.otazka_ID = 11 
                    ORDER BY datum_pridania_recenzie ASC
                    LIMIT $limit";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $sp_id);
        $stmt->execute();
        $result = $stmt->get_result();

        echoComments($sp_id, $conn, $result);
    }

    function dispLoadMoreCommButt($sp_id) {

        echo <<<EOP
        <div id="loadMoreCommDiv">
            <form id="loadMoreComm" class="px-2">
            <input type='hidden' id='articleId' value=$sp_id>
            <button type='submit' id='loadMoreCommButt'>Načítať viac</button>
            </form>
        </div>
EOP;
        echo <<<EOP
            <script>
                if (document.getElementById("sortButts").style.display === "none") {
                    document.getElementById("loadMoreCommDiv").style.display = "none"
                }
            </script>
EOP;
    }
    function dispOtazky($conn) {

        $sql = "SELECT * FROM otazky_pre_dotaznik ORDER BY id ASC";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $queryResult = $result->num_rows;

        for ($i = 0; $i < $queryResult; $i++) {

            $otazky = $result->fetch_array(MYSQLI_ASSOC);

            $id = "otazka" . $otazky['id'];
            $label = $otazky['znenie_otazky'];

            if ($i == $queryResult-1) {
                echo <<<EOP
                        <div class="form-group">
                        <label for=$id class="dotaznik-label">$label 
                            <span class="text-danger"></span>
                        </label>
                        <textarea class="form-control dotaznik-text" id=$id rows="2" placeholder=" ... "></textarea>
                        </div>   
    EOP;

            } else {
                echo <<<EOP
                        <div class="form-group">
                        <label for=$id class="dotaznik-label">$label 
                            <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control dotaznik-text" id=$id rows="2" placeholder=" ... "></textarea>
                        </div>            
                    EOP;
            }
        }
    }

    function dispCommentBody($commentId) {

        $conn = connectDbs();

        if ($conn -> connect_errno) {
            echo "Failed to connect to MySQL: " . $conn -> connect_error;
            exit();
        }

        $sql = "SELECT *
                FROM dotaznik d
                INNER JOIN otazky_pre_dotaznik opd on d.otazka_ID = opd.id
                WHERE d.recenzia_ID=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $commentId);
        $stmt->execute();
        $result = $stmt->get_result();
        $queryResult = $result->num_rows;

        for($i = 0; $i < $queryResult-1; $i++) {

            $dotaznik = $result->fetch_array(MYSQLI_ASSOC);
            echo "<h6 class='comment-box-otazka'>" . $dotaznik['znenie_otazky'] . "</h6>";
            echo "<p>" . Nl2br($dotaznik['odpoved']) . "</p>";

            if ($i < $queryResult-2) echo "<br>";

        }
    }
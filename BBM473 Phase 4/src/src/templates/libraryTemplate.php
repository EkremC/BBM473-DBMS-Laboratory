<?php

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $lib = new Library();
    echo $lib->getLibraryContent($_POST['id']);
}

class Library
{
    private $db;
    private $userid;
    private $shelfid;
    private $tabs_format = "
        <div class=\"ui pointing secondary demo menu\">
            <a class=\"active red item\" data-tab=\"first\">E-books</a>
            <a class=\"blue item\" data-tab=\"second\">Audio-books</a>
        </div>

        <div class=\"ui active tab segment\" data-tab=\"first\">%s</div>
        <div class=\"ui tab segment\" data-tab=\"second\">%s</div>
        ";

    function __construct()
    {
        include "../DB.php";
        $this->db = new DB();
        session_start();
        $this->userid = $_SESSION["user"];
    }

    function getLibraryContent($shelfid)
    {
        if ($shelfid == -1) {
            $tabs = sprintf($this->tabs_format, $this->getFiles("LIBRARY_EBOOK_VIEW", 0), $this->getFiles("LIBRARY_AUDIOBOOK_VIEW", 1));
            return json_encode(['title' => 'Library', 'content' => $tabs]);
        } else {
            $this->shelfid = $shelfid;
            $shelfname = $this->db->selectById('SHELF', 'SHELFID', $shelfid)[1]['SHELFNAME'][0];
            $tabs = sprintf($this->tabs_format, $this->getFiles("SHELF_EBOOK_VIEW", 0), $this->getFiles("SHELF_AUDIOBOOK_VIEW", 1));
            return json_encode(['title' => $shelfname, 'content' => $tabs]);
        }

    }

    function getFiles($view_name, $type)
    {
        $detail = $type == 0 ? "Number of pages" : "Duration";
        $book_list = "<div class=\"ui relaxed divided items\">";
        $book = "
                <div class=\"item\">
                    <a class=\"ui tiny rounded image\" onclick='%s'>
                        <img class='ui image hoverZoomLink' src=\"https://www.teachprivacy.com/wp-content/uploads/Orwell-1984-Book-Cover-02.jpg\">
                    </a>
                    <div class=\"middle aligned content\">
                        <a class=\"header\" onclick='%s'>%s</a>
                        <div class=\"meta\">
                            <div class=\"ui horizontal list\">
                            %s
                            </div>
                        </div>
                        <div class='description'>
                        <div class=\"ui label\" onclick='%s'>
                                Publisher
                                <a class=\"detail\">%s</a>
                            </div>
                            <div class=\"ui label\"  onclick='%s'>
                                " . $detail . "
                                <a class=\"detail\">%s</a>
                            </div>
                        </div>
                        <div class=\"extra\">
                            <a id='file-%s' class=\"ui label\" onclick='userRemoveFile()'>
                              Remove
                              <i class=\"delete icon\"></i>
                            </a>
                        </div>
                    </div>
                </div>
                    ";

        $author = "
            <div class=\"item\">
                <div class=\"content\">
                    <a class=\"header\" onclick='%s'>%s</a>
                </div>
            </div>";


        if ($this->shelfid != null) {
            $removeid = "-shelf-" . $this->shelfid;
            $sql = " SELECT * FROM " . $view_name . " WHERE USERID = " . $this->userid . " AND SHElFID = " . $this->shelfid;
            list($n_row, $result) = $this->db->executeQuery($sql);
        } else {
            $removeid = "";
            list($n_row, $result) = $this->db->selectById($view_name, 'USERID', $this->userid);
        }

        list($n_row_author, $result_author) = $this->db->selectAll('BOOKAUTHOR_VIEW');
        for ($i = 0; $i < $n_row; $i++) {
            $onclick = "showBookContent(" . $result['BOOKID'][$i] . ", 0)";
            $authors = "";
            for ($j = 0; $j < $n_row_author; $j++) {
                if ($result['BOOKID'][$i] == $result_author['BOOKID'][$j]) {
                    $authors .= sprintf($author, $onclick, $result_author['AUTHOR_NAME'][$j]);
                }
            }
            $detail = $type == 0 ? $result["PAGE_NUMBER"][$i] : $result["TOTAL_DURATION"][$i];
            $book_list .= sprintf($book, $onclick, $onclick, $result["BOOKNAME"][$i], $authors,
                $onclick, $result["PUBLISHER_NAME"][$i], $onclick, $detail, $result["FILEID"][$i] . $removeid);
        }
        $book_list .= "</div>";
        return $book_list;
    }

}
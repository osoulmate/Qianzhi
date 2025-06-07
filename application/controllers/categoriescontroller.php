<?php

class CategoriesController extends BaseController {
    protected $_index_view_items_limit;
    protected $_class_view_items_limit;
    protected $_year_view_items_limit;
    protected $_month_view_items_limit;
    protected $_day_view_items_limit;
    protected $_search_view_items_limit;
    protected $_var = ' flag<>-1 and isview = 1 ';
    protected $_comment_num = array();
    function beforeAction () {
        $this->Category->orderBy('id','ASC');
        $this->Category->showHasOne();
        $categories = $this->Category->search();
        $this->set('categories',$categories);
        $query = "select * from systems";
        $pageLimit = $this->Category->custom($query);
        if(!empty($pageLimit)){
            $pageLimit = $pageLimit[0];
            //$this->set('pageL',$pageLimit);
            $this->_index_view_items_limit = $pageLimit['System']['index_view_items_limit'];
            $this->_class_view_items_limit = $pageLimit['System']['class_view_items_limit'];
            $this->_year_view_items_limit = $pageLimit['System']['year_view_items_limit'];
            $this->_month_view_items_limit = $pageLimit['System']['month_view_items_limit'];
            $this->_day_view_items_limit = $pageLimit['System']['day_view_items_limit'];
            $this->_search_view_items_limit = $pageLimit['System']['search_view_items_limit'];
        }
        $num_sql = "select * from ( select count(id) as num,article_id from comments group by article_id) as temp";
        $num_result = $this->Category->custom($num_sql);
        if(!empty($num_result)){
        	foreach ($num_result as $result) {
        		$this->_comment_num[$result['Temp']['article_id']] = $result['Temp']['num'];
        	}
        	$this->set('comment_num',$this->_comment_num);
        }
    }

    function view($categoryName = null,$page = 'page',$pageNumber=1) {
        $this->Category->setPage($pageNumber);
        //$this->Category->setLimit('5');
        $this->Category->setLimit($this->_class_view_items_limit);
        $this->Category->setFlag($this->_var);
        $this->Category->name = $categoryName;

        $this->Category->orderBy('id','ASC');
        $this->Category->showHasOne();
        $this->Category->showHasMany();
        $categories = $this->Category->search();
        $this->set('categories',$categories);
        $totalPages = $this->Category->totalPages($categoryName);
        if(empty($totalPages) || ($pageNumber > $totalPages)){
            $this->set('error_page','true');
        }
        $this->set('totalPages',$totalPages);
        $this->set('currentPageNumber',$pageNumber);
        $this->set('currentLocation',$categoryName);
        $this->set('htmlTitle','千知博客-'.$categoryName);


    }   

    function index() {
        $_var = ' flag=2 and isview = 1 ';
        $indexPageItemsLimit = $this->_index_view_items_limit;
        $indexSql = "SELECT * FROM articles where {$_var} order by date DESC limit {$indexPageItemsLimit}";
        $article = $this->Category->custom($indexSql);
        $this->set('article',$article);
        $this->set('htmlTitle','千知博客');

    }
    function article($year = null,$month = null,$day = null,$indexId = null) {
        if(!empty($month)&&(strlen($month)<2)&&($month!='0')){
            $month = '0'.$month;
        }
        if(!empty($day)&&(strlen($day)<2)&&($day!='0')){
            $day = '0'.$day;
        }

        $date = $year.'-'.$month.'-'.$day;
        //$title = str_replace('-',' ',$title);
        //$title = str_replace('井','#',$title);
        //$indexId = md5($title.$date.'qianzhi');
        //$articleSql = "SELECT * FROM articles where {$this->_var} and index_id = '{$indexId}' ";
        $articleSql = "SELECT * FROM articles where {$this->_var} and index_id = '{$indexId}' ";
        $article = $this->Category->custom($articleSql);
        $this->set('article',$article);
        if(!empty($article[0]['Article']['title'])){
            $this->set('htmlTitle','千知博客-'.$article[0]['Article']['title']);
            $categoryId = $article[0]['Article']['category_id'];
            $articleId = $article[0]['Article']['id'];
            $previousSql = "SELECT id,index_id,title,date FROM articles where {$this->_var} and category_id='{$categoryId}' and date>(select date from articles where id='{$articleId}') order by date ASC limit 1";
            $nextSql = "SELECT id,index_id,title,date FROM articles where {$this->_var} and category_id='{$categoryId}' and date<(select date from articles where id='{$articleId}') order by date DESC limit 1";
            $commentSql = "SELECT comments.id,comments.parent_id,comments.date,comments.content,users.name FROM comments,users WHERE comments.user_id=users.id AND comments.article_id={$articleId}";
            $previous = $this->Category->custom($previousSql);
            $next = $this->Category->custom($nextSql);
            $comments = $this->Category->custom($commentSql);
            $post = $this->Category->save("update articles set hits = hits+1 where id ='{$articleId}'");
            $this->set('previous',$previous);
            $this->set('next',$next);
            $this->set('comments',$comments);
            $this->set('articleid',$articleId);
            //$this->set('titlehash',$indexId);
        }else{
            $errinfo = $this->Category->getError();
            $this->set('error_page','true');
        }

    }
    function copyright() {
        $this->set('htmlTitle','千知博客-版权说明');

    }
    function about() {
        $this->set('htmlTitle','千知博客-关于千知');

    }
    function soso() {
        $arr = array();
        $searchPageItemsLimit = $this->_search_view_items_limit;
        if(!empty($_POST['key'])){
            $_POST['key'] = '%'.$_POST['key'].'%';
            $query = "select * from articles where {$this->_var} and title like '{$_POST['key']}' limit {$searchPageItemsLimit}";
            $article = $this->Category->custom($query);
            if(!empty($article)){
                $this->set('article',$article);
            }else{
                $this->set('error_page','true');
            }
            
        }
        $this->set('htmlTitle','千知搜索');
    }
    function archive() {
        $query = "select left(date,7) as date,count(date) as count from articles where {$this->_var} group by left(date,7);";
        $monthCount = $this->Category->custom($query);
        $this->set('monthCount',$monthCount);
        $this->set('htmlTitle','千知博客-归档');

    }
    function monthview($year = null,$month = null,$page = 'page',$pageNumber=1){
        if(!empty($month)&&(strlen($month)<2)&&($month!='0')){
            $month = '0'.$month;
        }
        if(!empty($day)&&(strlen($day)<2)&&($day!='0')){
            $day = '0'.$day;
        }
        $date = $year.'-'.$month.'%';
        $monthPageItemsLimit = $this->_month_view_items_limit;
        $limit = $monthPageItemsLimit;
        $offset = ($pageNumber-1)*$limit;
        $query = "select * from articles where {$this->_var} and date like '{$date}' order by  date desc limit {$limit} offset {$offset} ";
        $monthView = $this->Category->custom($query);
        $this->set('monthView',$monthView);

        $totalSql = "select count(id) as number from articles where {$this->_var} and date like '{$date}'";
        $total = $this->Category->single($totalSql);
        $totalPages = ceil($total['number']/$limit);
        $this->set('totalPages',$totalPages);
        $this->set('currentPageNumber',$pageNumber);
        $this->set('currentLocation',$year.'/'.$month);
        $this->set('htmlTitle','千知博客-月度汇总');
    }
    function yearview($year = null,$page = 'page',$pageNumber=1){
        $this->set('currentLocation',$year);
        $year = $year.'%';
        $yearPageItemsLimit = $this->_year_view_items_limit;
        $limit = $yearPageItemsLimit;
        $offset = ($pageNumber-1)*$limit;
        $query = "select * from articles where {$this->_var} and date like '{$year}' order by  date desc limit {$limit} offset {$offset} ";
        $yearView = $this->Category->custom($query);
        $this->set('yearView',$yearView);

        $totalSql = "select count(id) as number from articles where {$this->_var} and date like '{$year}'";
        $total = $this->Category->single($totalSql);
        $totalPages = ceil($total['number']/$limit);
        $this->set('totalPages',$totalPages);
        $this->set('currentPageNumber',$pageNumber);
        $this->set('htmlTitle','千知博客-年度汇总');
    }
    function dayview($year = null,$month = null,$day = null,$page = 'page',$pageNumber=1){
        if(!empty($month)&&(strlen($month)<2)&&($month!='0')){
            $month = '0'.$month;
        }
        if(!empty($day)&&(strlen($day)<2)&&($day!='0')){
            $day = '0'.$day;
        }
        $date = $year.'-'.$month.'-'.$day.'%';
        $dayPageItemsLimit = $this->_day_view_items_limit;
        $limit = $dayPageItemsLimit;
        $offset = ($pageNumber-1)*$limit;
        $query = "select * from articles where {$this->_var} and date like '{$date}' order by  date desc limit {$limit} offset {$offset} ";
        $dayView = $this->Category->custom($query);
        $totalSql = "select count(id) as number from articles where {$this->_var} and date like '{$date}'";
        $total = $this->Category->single($totalSql);
        $totalPages = ceil($total['number']/$limit);
        $this->set('totalPages',$totalPages);
        $this->set('currentPageNumber',$pageNumber);
        $this->set('currentLocation',$year.'/'.$month.'/'.$day);

        $this->set('dayView',$dayView);
        $this->set('htmlTitle','千知博客-每日汇总');
    }
    function notfound() {
        $this->Category->orderBy('id','ASC');
        $this->Category->showHasOne();
        $categories = $this->Category->search();
        $this->set('categories',$categories);
        $this->set('htmlTitle','千知博客');     
    }
    function afterAction() {

    }
}


<?php

// This is a helper class to make paginating 
// records easy.
class Pagination {
	
  public $current_page;
  public $per_page;
  public $total_count;

  public function __construct($page=1, $per_page=5, $total_count=0){
      $this->current_page=$page;
      $this->per_page=$per_page;
      $this->total_count=$total_count;
  }
//pointer of database in pagination
  public function offset() { //points to database record -1
    // Assuming 20 items per page:
    // page 1 has an offset of 0    (1-1) * 20
    // page 2 has an offset of 20   (2-1) * 20
    //   in other words, page 2 starts with item 21
      return $this->prev_page()*$this->per_page;
      
  }
//pointer in pagination excluding database
  public function total_pages() {
    return ceil( $this->total_count / $this->per_page); 
  }
	
  public function prev_page() {
     return $this->current_page-1;
  }
  
  public function next_page() {
     return $this->current_page+1;
  }

    public function has_prev_page() {//points to minimum page 
        return $this->current_page>1 ? TRUE : FALSE;
    }

    public function has_next_page() {//points to max page 
          return $this->current_page < ceil( $this->total_count / $this->per_page)? TRUE : FALSE;
    }


}

?>

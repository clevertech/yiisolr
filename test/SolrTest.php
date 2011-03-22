<?php
class SolrTest extends CTestCase
{  
     
    private $_solrMgr = null;

    protected function setUp()
	{
		parent::setUp();
		if($this->_solrMgr === null)
			$this->_solrMgr = Yii::app()->solrManager; 
	}
	
	public function testAddOneDocument()
    {
		$data = array('id'=>1,'title'=>'Test Data Alpha Beta Charlie Delta Echo');
		$this->assertTrue($this->_solrMgr->updateOne($data));
	}
	
	public function testAddMultipleDocuments()
	{
		$data = array();
		$one = array('id'=>2,'title'=>'Testing Multi Doc Upload Document One');
		$two = array('id'=>3,'title'=>'Testing Multi Doc Upload Document Two');
		$three = array('id'=>4,'title'=>'Testing Multi Doc Upload Document Three');
		$data[] = $one;
		$data[] = $two;
		$data[] = $three;
		$this->assertTrue($this->_solrMgr->updateMany($data));
	}
	
	public function testBasicSearch()
	{
		
		//just so that we don't have one test relying on another, we'll explicitly re-add/update the title id = 1
		$data = array('id'=>1,'title'=>'Test Data Alpha Beta Charlie Delta Echo');
		$this->assertTrue($this->_solrMgr->updateOne($data));
		
		$result = $this->_solrMgr->get('title:Test', 0, 30, array());
		
		$this->assertEquals($result->response->numFound, count($result->response->docs));
		
		foreach($result->response->docs as $doc)
		{
		   if(1 == $doc->id)
		   {
		        $compareTitle = $doc->title;
		        break;
		   }
		   
		}
		
		$this->assertEquals('Test Data Alpha Beta Charlie Delta Echo', $compareTitle);
	}
	
}
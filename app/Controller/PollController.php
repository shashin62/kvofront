<?php

App::uses('AppController', 'Controller');

Class PollController extends AppController {
    
    public $name = 'Poll';
    
    public $uses = array('Poll','PollAnswer');
    
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {       
        $pollId = $this->request->params['id'];
        
        $data = $this->Poll->find('all', array(
            'conditions' => array('Poll.id' => $pollId))
        );
        $answers = array();
        if ($data[0]['Poll']['answers']) {
            $answers = unserialize($data[0]['Poll']['answers']);
        }

        $fData = array();
        $fData['name'] = $data[0]['Poll']['name'];
        
        $fData['id'] = $data[0]['Poll']['id'];
        $fData['control_type'] = $data[0]['Poll']['control_type'];
        
        $fData['answers'] = array();
        $fData['ans_no'] = 0;
        if (count($answers)) {
            $fData['answers'] = $answers;
            $fData['ans_no'] = count($answers);
        }
        
        $this->set('pollData', $fData);
    }
    
    public function saveVote() {
        $this->layout = 'ajax';
        $this->autoRender = false;
        $id = $_REQUEST['id'];
        $controlType = $_REQUEST['control_type'];
        
        $vote = $_REQUEST['poll_answer'];
        
         
        if (isset($_COOKIE['poll' . "_" . $id])) {
            $msg = "You have already cast your vote.";
            $err = 1;
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
            if ($controlType == 'radio') {
                $data = array('poll_id' => $id, 'ip_address' => $ip, 'poll_option' => $vote);
                $this->PollAnswer->save ($data);
            } else {
                foreach ($vote as $opt) {
                    $data = array('poll_id' => $id, 'ip_address' => $ip, 'poll_option' => $opt);
                    $this->PollAnswer->save ($data);
                }
            }
            
            $expire = time() + 60 * 60 * 24 * 30;
            setcookie("poll" . "_" . $id, "poll" . "_" . $id, $expire);

            $msg = "You have successfully cast your vote.";
            $err = 0;
        }
        
        echo json_encode(array('error' => $err, 'message' => $msg));
    }
    
    public function showResult() {
        $this->layout = 'ajax';
        
        $id = $_REQUEST['id'];
        $totalResult = $this->PollAnswer->find('count', array(
            'conditions' => array('poll_id' => $id)
        ));
        
        $pollCount = $this->PollAnswer->find('all', array(
            'fields' => array('poll_option', 'COUNT(id) AS vote_count'),
            'conditions' => array('poll_id' => $id),
            'group' => array('poll_option')
        ));
        
        $voteCounts = array();
        
        foreach ($pollCount as $val) {
            $voteCounts[$val['PollAnswer']['poll_option']] = $val[0]['vote_count'];
        }
        
        $data = $this->Poll->find('all', array(
            'conditions' => array('Poll.id' => $id))
        );
        $answers = array();
        if ($data[0]['Poll']['answers']) {
            $answers = unserialize($data[0]['Poll']['answers']);
        }
        
        $this->set('pollOptions', $answers);
        $this->set('voteCounts', $voteCounts);
        $this->set('totalResult', $totalResult);
    }

}   
<?php
class Api_model extends CI_Model{ 
    
    public function __construct(){
        
            $this->load->database();
    }
    

    public function get_all_row($table_name='',$data=array()){
        if($data){
        return $this->db->select($data)->get($table_name)->result_array();
        }else{
            return $this->db->select()->get($table_name)->result_array();
        }
    }
    
    
     function sendCallnotification($token,$title,$message,$user_id,$type)
    {
        
        //  $oppToken                = $this->input->post('opp_token'); 
        //  $body                = $this->input->post('message'); 
        //  $title                = $this->input->post('title'); 
        
        
        
        
       $insertdata = array(
           
           'title'=>$title,
           'description'=>$message,
           'user_id'=>$user_id,
           'type'=>$type,
           
       );
       
       $this->Api_model->insert('tbl_notification',$insertdata);


          $oppToken                = $token; 
          $body                = $message; 
          $title                = $title; 

        
        
             $url = "https://fcm.googleapis.com/fcm/send";
            $token = $oppToken;
            $serverKey = 'AAAAY3lWIc8:APA91bG0mGCqUULtU6AqJRmKkRyyMUwckmMtmKh7aFOs8FNaS5zjvJTMN5Ru2oF9UsaEIqmkrGo9F0Onh3x0fAkHoYVOy6g8uQf55UuOEDg2XKvpTHKnN30nmJ8m9noawWEqUiiaVCzs';

            
            $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
            
            $aps = array('sound' => 'aiff.mp3');
            
            $payload = array('aps' => $aps);
            
            $apns = array('payload' => $payload);
            
            $arrayToSend = array('to' => $token,'apns' => $apns, 'notification' => $notification,'priority'=>'high');
            
            
            
            $json = json_encode($arrayToSend);
            //echo $json;
           // die;
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            //Send the request
            $response = curl_exec($ch);
            //Close request
            //echo $response;
           // die;
        //     if ($response === FALSE) {
        //         die('FCM Send Error: ' . curl_error($ch));
                
        //          $data['status'] = "1";            
        //     $data['message'] = "Error";
        //     $data['text'] ='FCM Send Error: ' . curl_error($ch);
            
        //     }
        //     else
        //     {
        //          $data['status'] = "1";            
        //     $data['message'] = "Success";
        //     $data['text'] ='FCM Send Success';
            
        //     }
            
            
        //      header('Content-type:application/json');
        // print json_encode($data);
        // exit;
            
            curl_close($ch);
    }
    
     function getPostingsList($lat,$lon,$search_key='',$radius='')
    {
        $this->db->select("tbl_post.id,latitude,longitude,111.111 * DEGREES(ACOS(COS(RADIANS('$lat')) * COS(RADIANS(tbl_post.latitude)) * COS(RADIANS('$lon' - tbl_post.longitude)) + SIN(RADIANS('$lat')) * SIN(RADIANS(tbl_post.latitude))))");
        $this->db->where('tbl_post.status','1');

        if ($search_key != "")
        {
            $this->db->where("tbl_post.title like '%$search_key%'");
            $this->db->or_where("tbl_post.description like '%$search_key%'");
            
        }
       
        if($radius!=0)
        {
        //   $this->db->having("distance_in_km<='$radius'");
        //   $this->db->order_by('distance_in_km','asc');
        }

        return $this->db->get('tbl_post');
    }

    
    public function get_where_row($tablename, $where = array()){
        
        $this->db->where($where);
        return $this->db->get($tablename)->row();
        
    }
    
    public function insert($table_name = '', $data=array()) {
        
        $this->db->insert($table_name,$data);
        return $this->db->insert_id();
    }
    
    public function update($table_name , $data ,$where){

        $this->db->update($table_name,$data,$where);
        $result = $this->db->get_where($table_name,$where);
        return $result->row();
    }
    
   public function delete_data($table_name,$id)
  {
    $this->db->where("id",$id);
    
    $this->db->delete($table_name);
    
    return;//onsuccess
 }
    
    public function get_country(){
        $select =   array(
                'tbl_users.country',
                'count(tbl_users.country) as Total'
            );  
        $result = $this->db
            ->select($select)
            ->from('tbl_users')
            ->group_by('tbl_users.country')
            ->get()
            ->result_array();
        return $result;
    }
    
     public function select_row($tablename, $where = array()){
        
        $this->db->where($where);
        return $this->db->get($tablename)->row();
        
    }
    
     public function select_result($tablename, $where = array(), $order_by = ""){ 
        
        return $this->db->where($where)->order_by($order_by)->get($tablename)->result();
        
    }
    
}
?>
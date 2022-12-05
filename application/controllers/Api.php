<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends My_Controller {
	
	function __construct()
	{
		parent::__construct();

		$this->load->library(array('session', 'form_validation'));
		$this->load->database();
		$this->load->helper(array('form', 'url', 'html'));
		$this->load->model('Api_model');
	}
	
	public function get_otp_user(){
        
        $phone_no                = $this->input->post('phone_no');
        $digits     = 4;
        $mobile_otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
        
        $query = "SELECT * FROM client WHERE phone_no = $phone_no";  
            $check_email = $this->db->query($query)->result();
        
        
        
        //echo  $check_email ;
        if($check_email){
            
            
                $check_email_data = $this->Api_model->get_where_row('client',array('phone_no' => $phone_no));
                 if($check_email_data->status == 0){
                     
                        $data['status'] = "0";                    
                       $data['message'] = "User Blocked";
                 }
                 else
                 {
                      $data['status'] = "1";                    
                 $data['message'] = "otp send to this number successfully";
            $data['type']='login';
             $data['otp']=$mobile_otp;
            $data['user_id']=$check_email_data->id;
                 }
               
           
            
        }
        else{
            
            
            $insert_data = array(
            
                'phone_no'      =>$phone_no,
                
                );
                
                $admin_id_fk = $this->Api_model->insert('client',$insert_data);
                
                
                
                if($admin_id_fk){
                
                $get_admin_res = $this->Api_model->select_row('client',array('id' => $admin_id_fk));
                }
                
               
            $data['status'] = "1";                    
            $data['message'] = "otp send to this number successfully";
            $data['type']='signup';
             $data['otp']=$mobile_otp;
            $data['user_id']=$get_admin_res->id;
            
        }
        
        header('Content-type:application/json');        
        print json_encode($data);        
        exit;
    }
    
    function update_profile_user()
    {
        $id              = $this->input->post('user_id');
        $name      = $this->input->post('name');
        $email       =$this->input->post('email');
        $image                = $this->input->post('image');
        $address                = $this->input->post('address');
        $latitude               = $this->input->post('latitude');
         $longitude               = $this->input->post('longitude');
          $token               = $this->input->post('token');
         $device               = $this->input->post('device');
      


        
       $userData=array(
                    'name'                  => $name,      
                    'email'                 => $email,
                    'image'              => $image,
                    'address'             => $address,
                    'latitude'        => $latitude,  
                    'longitude'        => $longitude, 
                    'token'        => $token, 
                    'device'        => $device, 
                );                
                
                if($this->Api_model->update('client',$userData,array('id' => $id)))
                {
                    $data['status']="1";                    
                    $data['message']="Updated Successfully";
                                        
                    $data['user_details'] = $userData;
                }
                else
                {
                    $data['status']="0";                    
                    $data['message']="Something went wrong";
                }               
        
        header( 'Content-type:application/json');        
        print json_encode( $data);        
        exit;        
    }
    
    function update_package_user()
    {
        $id              = $this->input->post('user_id');
        $product_pckage      = $this->input->post('product_pckage');
        $service_package       =$this->input->post('service_package');
       


        
       $userData=array(
                    'product_pckage'                  => $product_pckage,      
                    'service_package'                 => $service_package,
                     
                );                
                
                if($this->Api_model->update('client',$userData,array('id' => $id)))
                {
                    $data['status']="1";                    
                    $data['message']="Updated Successfully";
                                        
                    $data['user_details'] = $userData;
                }
                else
                {
                    $data['status']="0";                    
                    $data['message']="Something went wrong";
                }               
        
        header( 'Content-type:application/json');        
        print json_encode( $data);        
        exit;        
    }
    
    public function package_list(){
       
     
     $user_type = $this->input->post('user_type');
       

        
            $query = "SELECT * FROM `package` WHERE user_type = $user_type"; 
            
         
       
      $master_res = $this->db->query($query)->result();
      
       
       if($master_res){
           $master_data = array();
           
           foreach($master_res as $key => $user_res)
           {

               $master_data[]= array('id' => $user_res->id,
                               'type' => $user_res->type,
                               'cost' => $user_res->cost,
                               'user_type' => $user_res->user_type,
                               'description' => $user_res->description,
                               
                               
                              
                              );
               
           }
            $data['status'] = "1";            
            $data['message'] = "Success";
            $data['list'] =$master_data;
       }
       else
        {
            $data['status'] = "0";            
            $data['message'] = "No Data Found";
        }
        
        header('Content-type:application/json');
        print json_encode($data);
        exit;
   }
   
   public function ads_list(){
       
     


        
            $query = "SELECT * FROM `ads`"; 
            
         
       
      $master_res = $this->db->query($query)->result();
      
       
       if($master_res){
           $master_data = array();
           
           foreach($master_res as $key => $user_res)
           {

               $master_data[]= array('id' => $user_res->id,
                               'image_url' => $user_res->image_url,
                               'link' => $user_res->link,
                              
                              
                              );
               
           }
            $data['status'] = "1";            
            $data['message'] = "Success";
            $data['list'] =$master_data;
       }
       else
        {
            $data['status'] = "0";            
            $data['message'] = "No Data Found";
        }
        
        header('Content-type:application/json');
        print json_encode($data);
        exit;
   }
   
   
   public function services_list(){
       
     


        
            $query = "SELECT * FROM `services` WHERE status = 1"; 
            
         
       
      $master_res = $this->db->query($query)->result();
      
       
       if($master_res){
           $master_data = array();
           
           foreach($master_res as $key => $user_res)
           {

               $master_data[]= array('id' => $user_res->id,
                               'name' => $user_res->name,
                               'image' => $user_res->image,
                               'cost' => $user_res->cost,
                              
                               
                              
                              );
               
           }
            $data['status'] = "1";            
            $data['message'] = "Success";
            $data['list'] =$master_data;
       }
       else
        {
            $data['status'] = "0";            
            $data['message'] = "No Data Found";
        }
        
        header('Content-type:application/json');
        print json_encode($data);
        exit;
   }
   
   
   public function get_otp_provider(){
        
        $phone_no                = $this->input->post('phone_no');
        $digits     = 4;
        $mobile_otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
        
        $query = "SELECT * FROM provider WHERE phone_no = $phone_no";  
            $check_email = $this->db->query($query)->result();
        
        
        
        //echo  $check_email ;
        if($check_email){
            
            
                $check_email_data = $this->Api_model->get_where_row('provider',array('phone_no' => $phone_no));
                 if($check_email_data->status == 0){
                     
                        $data['status'] = "0";                    
                       $data['message'] = "User Blocked";
                 }
                 else
                 {
                      $data['status'] = "1";                    
                 $data['message'] = "otp send to this number successfully";
            $data['type']='login';
             $data['otp']=$mobile_otp;
            $data['user_id']=$check_email_data->id;
                 }
               
           
            
        }
        else{
            
            
            $insert_data = array(
            
                'phone_no'      =>$phone_no,
                
                );
                
                $admin_id_fk = $this->Api_model->insert('provider',$insert_data);
                
                
                
                if($admin_id_fk){
                
                $get_admin_res = $this->Api_model->select_row('provider',array('id' => $admin_id_fk));
                }
                
               
            $data['status'] = "1";                    
            $data['message'] = "otp send to this number successfully";
            $data['type']='signup';
             $data['otp']=$mobile_otp;
            $data['user_id']=$get_admin_res->id;
            
        }
        
        header('Content-type:application/json');        
        print json_encode($data);        
        exit;
    }
    
    function update_profile_provider()
    {
        $id              = $this->input->post('user_id');
        $name      = $this->input->post('name');
        $email       =$this->input->post('email');
        $image                = $this->input->post('image');
        $address                = $this->input->post('address');
        $latitude               = $this->input->post('latitude');
         $longitude               = $this->input->post('longitude');
          $token               = $this->input->post('token');
         $device               = $this->input->post('device');
         
         
         $service_id               = $this->input->post('service_id');
          $service_name               = $this->input->post('service_name');
         $aadhaar               = $this->input->post('aadhaar');
      


        
       $userData=array(
                    'name'                  => $name,      
                    'email'                 => $email,
                    'image'              => $image,
                    'address'             => $address,
                    'latitude'        => $latitude,  
                    'longitude'        => $longitude, 
                    'token'        => $token, 
                    'device'        => $device, 
                    'service_id'        => $service_id, 
                    'service_name'        => $service_name, 
                    'aadhaar'        => $aadhaar, 
                );                
                
                if($this->Api_model->update('provider',$userData,array('id' => $id)))
                {
                    $data['status']="1";                    
                    $data['message']="Updated Successfully";
                                        
                    $data['user_details'] = $userData;
                }
                else
                {
                    $data['status']="0";                    
                    $data['message']="Something went wrong";
                }               
        
        header( 'Content-type:application/json');        
        print json_encode( $data);        
        exit;        
    }
    
    function update_package_provider()
    {
        $id              = $this->input->post('user_id');
        $product_pckage      = $this->input->post('product_pckage');



        
       $userData=array(
                    'product_pckage'                  => $product_pckage,      

                );                
                
                if($this->Api_model->update('provider',$userData,array('id' => $id)))
                {
                    $data['status']="1";                    
                    $data['message']="Updated Successfully";
                                        
                    $data['user_details'] = $userData;
                }
                else
                {
                    $data['status']="0";                    
                    $data['message']="Something went wrong";
                }               
        
        header( 'Content-type:application/json');        
        print json_encode( $data);        
        exit;        
    }
    
   public function get_profile_details(){
        
         $id = $this->input->post('user_id');
           $type = $this->input->post('user_type');
        
        
        
        
       
        
        $user_res = $this->Api_model->get_where_row($type,array('id' => $id));
        
        if($user_res){
            
            
            
            if($type == 'client')
            {
                         $user_data = array('id' => $user_res->id,
                               'name' => $user_res->name,
                               'email' => $user_res->email,
                               'address' => $user_res->address,
                               'phone_no' => $user_res->phone_no,
                               'image' => $user_res->image,
                               'latitude' => $user_res->latitude,
                               'longitude' => $user_res->longitude,
                               'service_package' => $user_res->service_package,
                               'product_pckage' => $user_res->product_pckage,
                               
                              );
                              
            }
            else
            {
                
                 $ser_res = $this->Api_model->get_where_row('services',array('id' => $user_res->service_id));
        
                             if($ser_res){
                                 
                                 $ser_data = array('id' => $ser_res->id,
                               'name' => $ser_res->name,
                               'image' => $ser_res->image,
                               'cost' => $ser_res->cost,
                              
                              );
            
            
                                }
                
                
                $user_data = array('id' => $user_res->id,
                               'name' => $user_res->name,
                               'email' => $user_res->email,
                               'address' => $user_res->address,
                               'phone_no' => $user_res->phone_no,
                               'image' => $user_res->image,
                               'latitude' => $user_res->latitude,
                               'longitude' => $user_res->longitude,
                               'product_pckage' => $user_res->product_pckage,
                                'service_id' => $user_res->service_id,
                                 'service_name' => $user_res->service_name,
                                  'aadhaar' => $user_res->aadhaar,
                                   'upi_id' => $user_res->upi_id,
                                    'wallet' => $user_res->wallet,
                                    'service' => $ser_res,
                               
                              );
            }
                              
            $data['status'] = "1";            
            $data['message'] = 'success';
            $data['user_data'] = $user_data;
                              
            
        }
        else
        {
            $data['status'] = "0";            
            $data['message'] = 'no_data';
        }
        
        header('Content-type:application/json');
        print json_encode($data);
        exit;
        
    }
    
    
    public function professional_list(){
       
          $origLat = $this->input->post('latitude');
          $origLon = $this->input->post('longitude');
          $service_id = $this->input->post('service_id');
         
         
           $dist = $this->input->post('distnace_in_miles'); // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
           
           if($dist == '')
           {
               $dist = 100; 
           }
       
            $tableName = "provider";
            $query = "";
         
             $query = "SELECT  id,name,phone_no,email,address,latitude,longitude,image,service_id,service_name,status,availability,ratings,total_rate, 3956 * 2 *
          ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)
          +COS($origLat*pi()/180 )*COS(latitude*pi()/180)
          *POWER(SIN(($origLon-longitude)*pi()/180/2),2))) 
          as distance FROM $tableName WHERE 
          longitude between ($origLon-$dist/cos(radians($origLat))*69) 
          and ($origLon+$dist/cos(radians($origLat))*69) 
          and latitude between ($origLat-($dist/69))
          and ($origLat+($dist/69)) 
          having distance < $dist  && service_id = $service_id ORDER BY distance limit 1000";  
          
          
       
      $master_res = $this->db->query($query)->result_array();
      
       
       if($master_res){
           $master_data = array();
           
           foreach($master_res as $key => $value){

            
               $master_data[]= array(
                   
                    'id' =>$value['id'],
                    'name' => $value['name'],
                    'phone_no' => $value['phone_no'],
                    'email'=>$value['email'],
                    'address'=>$value['address'],
                    'latitude'=>$value['latitude'],
                    'longitude' => $value['longitude'],
                    'image'=>$value['image'],
                    'service_id'=>$value['service_id'],
                    'service_name'=>$value['service_name'],
                    'status'=>$value['status'],
                    'availability'=>$value['availability'],
                    'ratings'=>$value['ratings'],
                    'total_rate' => $value['total_rate'],
                   
               );
               
           }
            $data['status'] = "1";            
            $data['message'] = $this->lang->line('success');
            $data['professional_list'] =$master_data;
       }
       else
        {
            $data['status'] = "0";            
            $data['message'] = $this->lang->line('no_data');
        }
        
        header('Content-type:application/json');
        print json_encode($data);
        exit;
   }
   
   
   public function add_rating_prof(){
        
        $user_id = $this->input->post('user_id');
        $prof_id = $this->input->post('prof_id');
        $rating = $this->input->post('rating');

         $check_user = $this->Api_model->get_where_row('client',array('id'=>$user_id));
         if($check_user)
         {
        $check_available = $this->Api_model->get_where_row('tbl_rating_prof',array('user_id' => $user_id));

        if($check_available)
        {
            
       
            
            $check_pass = $this->Api_model->get_where_row('tbl_rating_prof',array('prof_id' => $prof_id));
            
            if($check_pass)
            {
                $insertdata = array(
                       
                       'rating' => $rating,
                       );
                
                $this->Api_model->update('tbl_rating_prof',$insertdata,array('prof_id' => $prof_id));

               
            }
            else
            {
                 $insertdata = array(
                           'user_id'=>$user_id,
                           'prof_id'=>$prof_id,
                           'rating' => $rating,
                           );
                       
                       $this->Api_model->insert('tbl_rating_prof',$insertdata);
                      
                      
            }
            
        }
        else
        {
            
             $insertdata = array(
                       'user_id'=>$user_id,
                       'prof_id'=>$prof_id,
                       'rating' => $rating,
                       );
                   
                   $this->Api_model->insert('tbl_rating_prof',$insertdata);
                  
                    
        }
        
        
        
        
        
        
        $query = "SELECT * FROM tbl_rating_prof WHERE prof_id = $prof_id";  
     
      $master_res = $this->db->query($query)->result();
      
      
      
      
      $rating_value = 0.0;
      $count = 0;
      
      if($master_res){

           foreach($master_res as $key => $value)
           {
               
               $oldRate = $value->rating;
               
               $rating_value = $rating_value + $oldRate;
               $count = $count + 1;
           }
            
       }
       
       
       
       $sum_of_max_rating_of_user_count = $count * 5;
        
        $updated_rating = ($rating_value * 5) / $sum_of_max_rating_of_user_count;

        

        $check_mail = $this->Api_model->get_where_row('provider',array('id' => $prof_id));
       // $check_pass = $this->Api_model->get_where_row('tbl_users',array('ratings' => $check_mail->ratings));

        $post_data = array(
            'ratings'=>$updated_rating,
            'total_rate'=>$count,
            );
            
            
            
           // $this->Api_model->insert('tbl_post',$post_data);
            
           $this->Api_model->update('provider',$post_data,array('id' => $prof_id));

            
            $data['status']="1";                        
            $data['message']=$this->lang->line('success');
            $data['post_details']= $post_data;
        }else{

            $data['status'] = "2";            
            $data['message'] = $this->lang->line('account not found');
        }    
        
        header( 'Content-type:application/json');
        print json_encode( $data);
        exit;
        
    }
    
    
    public function add_booking(){
        
        $user_id                = $this->input->post('user_id');
        $provider_id                = $this->input->post('provider_id');
        $address                = $this->input->post('address');
        $latitude                = $this->input->post('latitude');
        $longitude                = $this->input->post('longitude');
        $date_time                = $this->input->post('date_time');
        $status                = $this->input->post('status');
        $cost                = $this->input->post('cost');
       
      
            
             $digits     = 10;
             $mobile_otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
            
            $insert_data = array(
            
                'user_id'      =>$user_id,
                'provider_id'      =>$provider_id,
                'address'      =>$address,
                'latitude'      =>$latitude,
                'longitude'      =>$longitude,
                'date_time'      =>$date_time,
                'status'      =>$status,
                'cost'      =>$cost,
                'booking_id'      =>'BK'.$mobile_otp,
                
                );
                
                $admin_id_fk = $this->Api_model->insert('booking',$insert_data);
                
                
                
                if($admin_id_fk){
                
                $get_admin_res = $this->Api_model->select_row('client',array('id' => $admin_id_fk));
                }
                
               
            $data['status'] = "1";                    
            $data['message']='success';
            $data['booking_id']='BK'.$mobile_otp;
            
        
        
        header('Content-type:application/json');        
        print json_encode($data);        
        exit;
    }
    
    
    function update_booking()
    {
        $id              = $this->input->post('booking_id');
        $status      = $this->input->post('status');
        $signature_image =  $this->input->post('signature_image');
        $user_id =  $this->input->post('user_id');
        $provider_id =  $this->input->post('provider_id');
        $cost =  $this->input->post('cost');



        
       $userData=array(
                    'status'                  => $status, 
                    'signature_image'                  => $signature_image, 
                    'updated_at'                 => date('Y-m-d H:i:s'),
                     
                );                
                
                if($this->Api_model->update('booking',$userData,array('id' => $id)))
                {
                    $data['status']="1";                    
                    $data['message']="Updated Successfully";
                                        
                    $data['user_details'] = $userData;
                    
                    
                     $digits     = 8;
                     $mobile_otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
            
                    
                    if($status == '5')
                    {
                        $insert_data = array(
                          'booking_id'      =>$id,
                           'cost'      =>$cost,
                          'type'      =>'credit',
                           'user_id'      =>$user_id,
                          'provider_id'      =>$provider_id,
                          'trasaction_id'  => 'TR'.$mobile_otp,
                      );
                      $admin_id_fk = $this->Api_model->insert('transactions',$insert_data);
                      
                      
                      $querynew = "SELECT * FROM provider WHERE id = $provider_id";  
            
            
            $check_rating = $this->db->query($querynew)->result();
            
            
           
             $check_count = 0;
            
            
            foreach($check_rating as $key => $value)
           {
              
                   $check_count = $value->wallet+$cost;
           }
           
               
            $updatedata = array(
            'wallet' =>$check_count,

            );

             $this->Api_model->update('provider',$updatedata,array('id' =>$user_id));
                      
                      
                      
                
                
                    }
                    
                    
                    
                    
                }
                else
                {
                    $data['status']="0";                    
                    $data['message']="Something went wrong";
                }               
        
        header( 'Content-type:application/json');        
        print json_encode( $data);        
        exit;        
    }
   
   
   public function booking_list(){
       
     
     
      $user_id              = $this->input->post('user_id');
        $user_type      = $this->input->post('user_type');
         $status      = $this->input->post('status');


        $query = "";
        
        if($user_type == '1')
        {
        
            $query = "SELECT * FROM `booking` WHERE user_id = $user_id"; 
            
        }
        else
        {
            
            if($status == '5')
            {
            
             $query = "SELECT * FROM `booking` WHERE provider_id = $user_id && status = $status"; 
             
            }
            else
            {
                 $query = "SELECT * FROM `booking` WHERE provider_id = $user_id"; 

            }

        }
            
         
       
      $master_res = $this->db->query($query)->result();
      
       
       if($master_res){
           $master_data = array();
           
           foreach($master_res as $key => $user_res)
           {
                       
                      $client_res = $this->Api_model->get_where_row('client',array('id' => $user_res->user_id));
                       if($client_res){
                           
                            $user_data = array('id' => $client_res->id,
                               'name' => $client_res->name,
                               'email' => $client_res->email,
                               'address' => $client_res->address,
                               'phone_no' => $client_res->phone_no,
                               'image' => $client_res->image,
                               'latitude' => $client_res->latitude,
                               'longitude' => $client_res->longitude,
                               'service_package' => $client_res->service_package,
                               'product_pckage' => $client_res->product_pckage,
                               
                              );
            
                        }
                        
                        
                        
                        $provider_res = $this->Api_model->get_where_row('provider',array('id' => $user_res->provider_id));
                       if($provider_res){
                           
                            $prov_data = array('id' => $provider_res->id,
                               'name' => $provider_res->name,
                               'email' => $provider_res->email,
                               'address' => $provider_res->address,
                               'phone_no' => $provider_res->phone_no,
                               'image' => $provider_res->image,
                               'latitude' => $provider_res->latitude,
                               'longitude' => $provider_res->longitude,
                               'product_pckage' => $provider_res->product_pckage,
                                'service_id' => $provider_res->service_id,
                                 'service_name' => $provider_res->service_name,
                                  'aadhaar' => $provider_res->aadhaar,
                                   'upi_id' => $provider_res->upi_id,
                                    'wallet' => $provider_res->wallet,
                               
                              );
            
                        }

                   

                        $master_data[]= array('id' => $user_res->id,
                               'user_id' => $user_res->user_id,
                               'provider_id' => $user_res->provider_id,
                               'address' => $user_res->address,
                               'latitude' => $user_res->latitude,
                               'longitude' => $user_res->longitude,
                               'date_time' => $user_res->date_time,
                               'status' => $user_res->status,
                               'booking_id' => $user_res->booking_id,
                               'cost' => $user_res->cost,
                               'updated_at' => $user_res->updated_at,
                               'signature_image' => $user_res->signature_image,
                               'client' => $user_data,
                               'provider' => $prov_data,
                              
                               
                              
                              );
               
           }
            $data['status'] = "1";            
            $data['message'] = "Success";
            $data['list'] =$master_data;
       }
       else
        {
            $data['status'] = "0";            
            $data['message'] = "No Data Found";
        }
        
        header('Content-type:application/json');
        print json_encode($data);
        exit;
   }
   
   
   public function get_booking_details(){
        
         $id = $this->input->post('booking_id');

        
        
        
       
        
        $user_res = $this->Api_model->get_where_row('booking',array('id' => $id));
        
        if($user_res){
            
            
                $client_res = $this->Api_model->get_where_row('client',array('id' => $user_res->user_id));
                       if($client_res){
                           
                            $user_data = array('id' => $client_res->id,
                               'name' => $client_res->name,
                               'email' => $client_res->email,
                               'address' => $client_res->address,
                               'phone_no' => $client_res->phone_no,
                               'image' => $client_res->image,
                               'latitude' => $client_res->latitude,
                               'longitude' => $client_res->longitude,
                               'service_package' => $client_res->service_package,
                               'product_pckage' => $client_res->product_pckage,
                               
                              );
            
                        }
                        
                        
                        
                        $provider_res = $this->Api_model->get_where_row('provider',array('id' => $user_res->provider_id));
                       if($provider_res){
                           
                            $prov_data = array('id' => $provider_res->id,
                               'name' => $provider_res->name,
                               'email' => $provider_res->email,
                               'address' => $provider_res->address,
                               'phone_no' => $provider_res->phone_no,
                               'image' => $provider_res->image,
                               'latitude' => $provider_res->latitude,
                               'longitude' => $provider_res->longitude,
                               'product_pckage' => $provider_res->product_pckage,
                                'service_id' => $provider_res->service_id,
                                 'service_name' => $provider_res->service_name,
                                  'aadhaar' => $provider_res->aadhaar,
                                   'upi_id' => $provider_res->upi_id,
                                    'wallet' => $provider_res->wallet,
                               
                              );
            
                        }
            
            
                $master_data = array('id' => $user_res->id,
                               'user_id' => $user_res->user_id,
                               'provider_id' => $user_res->provider_id,
                               'address' => $user_res->address,
                               'latitude' => $user_res->latitude,
                               'longitude' => $user_res->longitude,
                               'date_time' => $user_res->date_time,
                               'status' => $user_res->status,
                               'booking_id' => $user_res->booking_id,
                               'updated_at' => $user_res->updated_at,
                               'cost' =>  $user_res->cost,
                               'signature_image' => $user_res->signature_image,
                               'client' => $user_data,
                               'provider' => $prov_data,
                              
                               
                              
                              );
                          
            $data['status'] = "1";            
            $data['message'] = 'success';
            $data['user_data'] = $master_data;
                              
            
        }
        else
        {
            $data['status'] = "0";            
            $data['message'] = 'no_data';
        }
        
        header('Content-type:application/json');
        print json_encode($data);
        exit;
        
    }
    
    
    public function transaction_list(){
       
     
     
      $user_id              = $this->input->post('provider_id');
       

        $query = "";
        
       
        
            $query = "SELECT * FROM `transactions` WHERE provider_id = $user_id"; 
            
        
       
         
       
      $master_res = $this->db->query($query)->result();
      
       
       if($master_res){
           $master_data = array();
           
           foreach($master_res as $key => $user_res)
           {
                       
                      $client_res = $this->Api_model->get_where_row('client',array('id' => $user_res->user_id));
                       if($client_res){
                           
                            $user_data = array('id' => $client_res->id,
                               'name' => $client_res->name,
                               'email' => $client_res->email,
                               'address' => $client_res->address,
                               'phone_no' => $client_res->phone_no,
                               'image' => $client_res->image,
                               'latitude' => $client_res->latitude,
                               'longitude' => $client_res->longitude,
                               'service_package' => $client_res->service_package,
                               'product_pckage' => $client_res->product_pckage,
                               
                              );
            
                        }
                        
                        
                        
                        $provider_res = $this->Api_model->get_where_row('provider',array('id' => $user_res->provider_id));
                       if($provider_res){
                           
                            $prov_data = array('id' => $provider_res->id,
                               'name' => $provider_res->name,
                               'email' => $provider_res->email,
                               'address' => $provider_res->address,
                               'phone_no' => $provider_res->phone_no,
                               'image' => $provider_res->image,
                               'latitude' => $provider_res->latitude,
                               'longitude' => $provider_res->longitude,
                               'product_pckage' => $provider_res->product_pckage,
                                'service_id' => $provider_res->service_id,
                                 'service_name' => $provider_res->service_name,
                                  'aadhaar' => $provider_res->aadhaar,
                                   'upi_id' => $provider_res->upi_id,
                                    'wallet' => $provider_res->wallet,
                               
                              );
            
                        }

                   

                        $master_data[]= array('id' => $user_res->id,
                               'user_id' => $user_res->user_id,
                               'provider_id' => $user_res->provider_id,
                               'booking_id' => $user_res->booking_id,
                               'cost' => $user_res->cost,
                               'type' => $user_res->type,
                               'created_at' => $user_res->created_at,
                               'trasaction_id' => $user_res->trasaction_id,
                               'client' => $user_data,
                               'provider' => $prov_data,
                              
                               
                              
                              );
               
           }
            $data['status'] = "1";            
            $data['message'] = "Success";
            $data['list'] =$master_data;
       }
       else
        {
            $data['status'] = "0";            
            $data['message'] = "No Data Found";
        }
        
        header('Content-type:application/json');
        print json_encode($data);
        exit;
   }
   
    public function withdraw_request(){
        
        $provider_id                = $this->input->post('provider_id');
        $cost                = $this->input->post('cost');
        $upi_id                = $this->input->post('upi_id');
        
      
            
             $digits     = 8;
             $mobile_otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
            
            $insert_data = array(
            
                'provider_id'      =>$provider_id,
                'cost'      =>$cost,
                'upi_id'      =>$upi_id,
                'withdraw_id'      =>'WD'.$mobile_otp,
                
                );
                
                $admin_id_fk = $this->Api_model->insert('withdraw_request',$insert_data);
                
                
                
               
                
               
            $data['status'] = "1";                    
            $data['message']='success';
            $data['withdraw_id']='WD'.$mobile_otp;
            
        
        
        header('Content-type:application/json');        
        print json_encode($data);        
        exit;
    }
    
    public function subscriped_list(){
       
     


        
            $query = "SELECT * FROM `products` WHERE subscription_product = 1"; 
            
         
       
      $master_res = $this->db->query($query)->result();
      
       
       if($master_res){
           $master_data = array();
           
           foreach($master_res as $key => $user_res)
           {

               $master_data[]= array('id' => $user_res->id,
                               'name' => $user_res->name,
                               'images' => $user_res->images,
                               'description' => $user_res->description,
                               'ratings' => $user_res->ratings,
                               'cost' => $user_res->cost,
                               'orginal_cost' => $user_res->orginal_cost,
                               'total_rate' => $user_res->total_rate,
                               'subscription_product' => $user_res->subscription_product,
                               'qty' => $user_res->qty,
                              
                               
                              
                              );
               
           }
            $data['status'] = "1";            
            $data['message'] = "Success";
            $data['list'] =$master_data;
       }
       else
        {
            $data['status'] = "0";            
            $data['message'] = "No Data Found";
        }
        
        header('Content-type:application/json');
        print json_encode($data);
        exit;
   }
   
   
    public function allproducts_list(){
       
     
           $search                = $this->input->post('search');
           
           
           if ($search == '')
           {

        
            $query = "SELECT * FROM `products` WHERE status = 1"; 
            
           }
           else
           {
                           $query = "SELECT * FROM `products` WHERE status = 1 AND name LIKE '%$search%' OR description LIKE '%$search%'"; 

           }
            
         
       
      $master_res = $this->db->query($query)->result();
      
       
       if($master_res){
           $master_data = array();
           
           foreach($master_res as $key => $user_res)
           {

               $master_data[]= array('id' => $user_res->id,
                               'name' => $user_res->name,
                               'images' => $user_res->images,
                               'description' => $user_res->description,
                               'ratings' => $user_res->ratings,
                               'cost' => $user_res->cost,
                               'orginal_cost' => $user_res->orginal_cost,
                               'total_rate' => $user_res->total_rate,
                               'subscription_product' => $user_res->subscription_product,
                               'qty' => $user_res->qty,
                              
                               
                              
                              );
               
           }
            $data['status'] = "1";            
            $data['message'] = "Success";
            $data['list'] =$master_data;
       }
       else
        {
            $data['status'] = "0";            
            $data['message'] = "No Data Found";
        }
        
        header('Content-type:application/json');
        print json_encode($data);
        exit;
   }

     public function add_update_cart(){
        
        $user_id                = $this->input->post('user_id');
        $product_id                = $this->input->post('product_id');
        $qty                = $this->input->post('qty');
        
      
            
            $query = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";  
            $check_email = $this->db->query($query)->result();
        
        
        
        if($check_email){
            
             $insert_data = array(
            
                'qty'      =>$qty,
                
                );
                
                
                 foreach($check_email as $key => $value)
                 {
              
                   $check_count = $value->id;
                 }
           
                
                $admin_id_fk = $this->Api_model->update('cart',$insert_data,array('id' => $check_count));
            
        }
        else
        {
            
            $insert_data = array(
            
                'user_id'      =>$user_id,
                'product_id'      =>$product_id,
                'qty'      =>$qty,
                
                );
                
                $admin_id_fk = $this->Api_model->insert('cart',$insert_data);
                
        }
                
               
                
               
            $data['status'] = "1";                    
            $data['message']='success';

        
        
        header('Content-type:application/json');        
        print json_encode($data);        
        exit;
    }
    
    
     public function delete_cart(){
        
         $post_id = $this->input->post('cart_id');
        
        
       
       
        
        
       
            
           $this->Api_model->delete_data('cart',$post_id);

            
            $data['status']="1";                        
            $data['message']='success'; 

        
        header( 'Content-type:application/json');
        print json_encode( $data);
        exit;
        
        
    }
    
    public function cart_list(){
       
     
         $post_id = $this->input->post('user_id');


        
            $query = "SELECT * FROM `cart` WHERE user_id = $post_id"; 
            
         
       
      $master_res = $this->db->query($query)->result();
      
       
       if($master_res){
           $master_data = array();
           
           $total = 0;
           foreach($master_res as $key => $user_res)
           {
               
               $sub_total = 0;
               $pr_cost = 0;
               
                $client_res = $this->Api_model->get_where_row('products',array('id' => $user_res->product_id));
                       if($client_res){
                           
                            $user_data =  array('id' => $client_res->id,
                               'name' => $client_res->name,
                               'images' => $client_res->images,
                               'description' => $client_res->description,
                               'ratings' => $client_res->ratings,
                               'cost' => $client_res->cost,
                               'orginal_cost' => $client_res->orginal_cost,
                               'total_rate' => $client_res->total_rate,
                               'subscription_product' => $client_res->subscription_product,
                               'qty' => $client_res->qty,
                              );
                              
                              $pr_cost = $client_res->cost;
                        }
                        
               
               $sub_total =  $pr_cost * $user_res->qty;
               
               $total = $total + $sub_total;

               $master_data[]= array('id' => $user_res->id,
                               'user_id' => $user_res->user_id,
                               'product_id' => $user_res->product_id,
                               'qty' => $user_res->qty,
                               'sub_total' => $sub_total,
                               'product' => $user_data,
                               
                              
                              );
               
           }
            $data['status'] = "1";            
            $data['message'] = "Success";
            $data['total'] = $total;
            $data['list'] =$master_data;
       }
       else
        {
            $data['status'] = "0";            
            $data['message'] = "No Data Found";
        }
        
        header('Content-type:application/json');
        print json_encode($data);
        exit;
   }

    public function add_order(){
        
        $user_id                = $this->input->post('user_id');
        $address                = $this->input->post('address');
        $latitude                = $this->input->post('latitude');
        $longitude                = $this->input->post('longitude');
        $date_time                = $this->input->post('date_time');
        $status                = $this->input->post('status');
        $cost                = $this->input->post('cost');
       
      
            
             $digits     = 10;
             $mobile_otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
            
            $insert_data = array(
            
                'user_id'      =>$user_id,
                'address'      =>$address,
                'latitude'      =>$latitude,
                'longitude'      =>$longitude,
                'date_time'      =>$date_time,
                'status'      =>$status,
                'cost'      =>$cost,
                'booking_id'      =>'OR'.$mobile_otp,
                
                );
                
                $admin_id_fk = $this->Api_model->insert('orders',$insert_data);
                
                $query = "SELECT * FROM `cart` WHERE user_id = $user_id"; 
                $master_res = $this->db->query($query)->result();
      
                if($master_res){
           $master_data = array();
           
           $total = 0;
           foreach($master_res as $key => $user_res)
           {
               
               $sub_total = 0;
               $pr_cost = 0;
               
                $client_res = $this->Api_model->get_where_row('products',array('id' => $user_res->product_id));
                       if($client_res){
                              
                              $pr_cost = $client_res->cost;
                        }
                        
               
               $sub_total =  $pr_cost * $user_res->qty;
               
               $total = $total + $sub_total;

               $master_data= array(
                               'user_id' => $user_res->user_id,
                               'product_id' => $user_res->product_id,
                               'qty' => $user_res->qty,
                               'sub_total' => $sub_total,
                               'booking_id'      =>'OR'.$mobile_otp,

                              );
                              
                 $admin_id_fk = $this->Api_model->insert('order_items',$master_data);
   
                              
               
                 }
                 
            
                 
         }
                
                
               
            $data['status'] = "1";                    
            $data['message']='success';
            $data['booking_id']='OR'.$mobile_otp;
            
            $querys = "DELETE FROM `cart` WHERE user_id = $user_id"; 
            $this->db->query($querys);
              
        
        
        header('Content-type:application/json');        
        print json_encode($data);        
        exit;
    }

     public function order_list(){
       
     
     
      $user_id              = $this->input->post('user_id');
         $status      = $this->input->post('status');


        $query = "";
        
     
        
            $query = "SELECT * FROM `orders` WHERE user_id = $user_id"; 
            
       
         
       
      $master_res = $this->db->query($query)->result();
      
       
       if($master_res){
           $master_data = array();
           
           foreach($master_res as $key => $user_res)
           {
                       
                      
                        
                        
                        

                        
                        $query = "SELECT * FROM `order_items` WHERE booking_id = '$user_res->booking_id'"; 
                        $provider_res = $this->db->query($query)->result();
                        
                       if($provider_res){
                           
                           $master_data1 = array();
           
                              foreach($provider_res as $key => $user_ress)
                               {
                                   
                                  
                                  
                                  $product_res = $this->Api_model->get_where_row('products',array('id' => $user_ress->product_id));
                       if($product_res){
                           
                            $prod_data = array('id' => $product_res->id,
                               'name' => $product_res->name,
                               'images' => $product_res->images,
                               'description' => $product_res->description,
                               'ratings' => $product_res->ratings,
                               'cost' => $product_res->cost,
                               'orginal_cost' => $product_res->orginal_cost,
                               'total_rate' => $product_res->total_rate,
                               'subscription_product' => $product_res->subscription_product,
                               'qty' => $product_res->qty,
                              
                               
                              
                              );
            
                        }
                                  
                                  
                    
                                   $master_data1[]= array('id' => $user_ress->id,
                                                   'user_id' => $user_ress->user_id,
                                                   'product_id' => $user_ress->product_id,
                                                   'qty' => $user_ress->qty,
                                                   'sub_total' => $user_ress->sub_total,
                                                   'booking_id' => $user_ress->booking_id,
                                                   'product' => $prod_data,
                                                  
                                                  
                                                  );
                                   
                               }
                                             
            
                        }

                   

                        $master_data[]= array('id' => $user_res->id,
                               'user_id' => $user_res->user_id,
                               'address' => $user_res->address,
                               'latitude' => $user_res->latitude,
                               'longitude' => $user_res->longitude,
                               'date_time' => $user_res->date_time,
                               'status' => $user_res->status,
                               'booking_id' => $user_res->booking_id,
                               'cost' => $user_res->cost,
                               'updated_at' => $user_res->updated_at,
                               'signature_image' => $user_res->signature_image,
                               'items' => $master_data1,
                              );
               
           }
            $data['status'] = "1";            
            $data['message'] = "Success";
            $data['list'] =$master_data;
       }
       else
        {
            $data['status'] = "0";            
            $data['message'] = "No Data Found";
        }
        
        header('Content-type:application/json');
        print json_encode($data);
        exit;
   }


    function imagePath($type){
        
        if($type=="profile_image")
        {
            $image_path = '.'.'/upload_path/profile_image/';
            $image_url=base_url('upload_path/profile_image/');
        }
        if($type=="excel")
        {
            $image_path = '.'.'/upload_path/excel/';
            $image_url=base_url('upload_path/excel/');
        }
        
       
        return $image_path."-".$image_url;
    }
    
    function doUpload(){
        
        $type = $this->input->post('file_type');
        
        $inv_id                  =       $this->input->post('inv_id');
        $user_id                 =       $this->input->post('user_id');
        
        if($type == 'excel')
        {
            if(!empty($inv_id) && empty(!$user_id))
            {
            
                if(!empty($_FILES["file_name"]) && $_FILES["file_name"]["error"] == UPLOAD_ERR_OK)
                {
                    $image_path=explode("-",$this->imagePath($type))[0];
                    $image_url=explode("-",$this->imagePath($type))[1];
                    $file_name_exp = explode(".",$_FILES["file_name"]['name']);
                    $new_name = strtotime(date('Y-m-d'));
                    
                    $config = array(
                        'upload_path' => $image_path,
                        'allowed_types' => '*',
                        'file_name' => $_FILES["file_name"]['name'],
                    );
            
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if(!$this->upload->do_upload('file_name'))
                    {
                        $result['status'] ='0';
                        $result['message'] = $this->upload->display_errors();                              
                    }
                    else
                    {
                        $datas = array('upload_data' => $this->upload->data());

                        $result['file_url'] = $image_url.$datas['upload_data']['file_name'];
                        $result['file_name'] = $datas['upload_data']['file_name'];
                        $result['file_size'] = $_FILES["file_name"]['size'];
                        $result['file_formate'] = $file_name_exp[1];
        
                        $result['status']='1';
                        $result['message']='Success';
                    }
                }
                else
                {
                    $result['status']='0';            
                    $result['message']='Please select an image to upload first.!!!';  
                }
            }
            else
            {
                $result['status']='0';            
                $result['message']='Please Add userid and invitation id';  
            }
        }
        else
        {
        
            if(!empty($_FILES["file_name"]) && $_FILES["file_name"]["error"] == UPLOAD_ERR_OK)
            {
                $image_path=explode("-",$this->imagePath($type))[0];
                $image_url=explode("-",$this->imagePath($type))[1];
                
                $file_name_exp = explode(".",$_FILES["file_name"]['name']);
    
                $new_name = strtotime(date('Y-m-d'));
                        
                $config = array(
                                'upload_path' => $image_path,
                                'allowed_types' => '*',
                                'file_name' => $_FILES["file_name"]['name'],
                );
                
                $this->load->library('upload', $config);
    
                $this->upload->initialize($config);
    
                if(!$this->upload->do_upload('file_name'))
                {
                    $result['status'] ='0';
                    $result['message'] = $this->upload->display_errors();                              
                }
                else
                {
                    $datas = array('upload_data' => $this->upload->data());
    
                    $result['file_url'] = $image_url.$datas['upload_data']['file_name'];
                    $result['file_name'] = $datas['upload_data']['file_name'];
                    $result['file_size'] = $_FILES["file_name"]['size'];
                    $result['file_formate'] = $file_name_exp[1];
    
                    $result['status']='1';
                    $result['message']='Success';
                }
            }
            else
            {
                $result['status']='0';            
                $result['message']='Please select an image to upload first.!!!';  
            }
        }
        
        header('Content-type:application/json');
        print json_encode($result);
        exit;
    }
    
   

	public function index()
	{
		echo "<h2>Unauthorized Access Controller</h2>";
	}
}
?>

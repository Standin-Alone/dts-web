$recipients_array = [{'sequence' => 1 , 'doc_number' => 'c',active => 0,office_code => '001'},
{'sequence' => 1.1 , 'doc_number' => 'c', active =>1,office_code => '002'},
{'sequence' => 1.2 , 'doc_number' => 'c', active =>1,office_code => '004'},
{'sequence' => 2 , 'doc_number' => 'c',active=>1,office_code => '003'} ]


foreach($recipients_array as $key=> $item){


if($doc_number == $item->doc_number && $office_code == $item->office_code){

$subtract_key = $key - 1;

$last_receiver = $recipients_array [$subtract_key];

}

}
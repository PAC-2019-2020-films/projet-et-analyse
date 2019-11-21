<?php
    
    
    namespace Service;
    
    
    use Model\Message;
    
    class MessagePublicService extends BaseService
    {
        
        /**
         * MessagePublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
        }
        
        /**
         * messageObjectBinder
         * @param array $messageArray
         * @return bool|Message
         */
        public function messageObjectBinder(array $messageArray)
        {
            if (isset($messageArray['id']) && isset($messageArray['last_name']) && isset($messageArray['email']) && isset($messageArray['content']) && isset($messageArray['created_at']) && isset($messageArray['treated'])) {
                $message = new Message(
                    $messageArray['id'],
                    $messageArray['last_name'],
                    $messageArray['email'],
                    $messageArray['content'],
                    $messageArray['created_at'],
                    $messageArray['treated'],
                );
                
                if (isset($messageArray['first_name'])) {
                    $message->setFirstName($messageArray['first_name']);
                }
                return $message;
            } else {
                return false;
            }
        }
        
        
        
        
        
    }
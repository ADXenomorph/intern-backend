<?php

use Phinx\Migration\AbstractMigration;

class Init extends AbstractMigration
{
    public function change()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS public.user
            (
                user_id serial PRIMARY KEY,
                first_name TEXT NOT NULL,
                last_name TEXT NOT NULL,
                created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
                updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
            );
            
            CREATE TABLE IF NOT EXISTS public.order
            (
                order_id serial PRIMARY KEY,
                user_id INT NOT NULL,
                item_name TEXT NOT NULL,
                created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
                updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
                FOREIGN KEY (user_id) REFERENCES public.user(user_id)
            );
            
            INSERT INTO public.user(first_name, last_name, created_at, updated_at) VALUES
                ('Sergey', 'Kremnev', NOW(), NOW()),
                ('John', 'Doe', NOW(), NOW()),
                ('Ivan', 'Ivanov', NOW(), NOW());
                
            INSERT INTO public.order(user_id, item_name, created_at, updated_at) VALUES
                (1, 'Logitech G15 Keyboard', NOW(), NOW()),
                (1, 'Roccat Kova mouse', NOW(), NOW()),
                (1, 'Intel Core I5-4670K CPU', NOW(), NOW());
        ");
    }
}

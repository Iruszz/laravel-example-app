export interface Ticket { 
    id: number; 
    title: string; 
    user_id: number; 
    category_id: number; 
    status_id: number; 
    created_at?: string; 
    updated_at?: string; 
}
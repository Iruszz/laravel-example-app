export interface Note {
  id: number;
  user_id: number;
  description: string;
  ticket_id: number;
  created_at?: string;
  updated_at?: string;
}
export interface Comment {
  id: number;
  user_id: number;
  comment: string;
  ticket_id: number;
  created_at?: string;
  updated_at?: string;
  recipient_id: number;
}
export interface Role {
  id: number;
  name: string;
}

export interface User {
  id: number;
  name: string;
  email: string;
  is_admin: boolean;
  phone?: string | null;
  user_role_id?: number | null;
  role?: Role | null; // <-- changed from string to Role object
  created_at?: string;
  updated_at?: string;
}

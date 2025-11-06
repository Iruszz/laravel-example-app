export interface User {
  id: number;
  name: string;
  email: string;
  inviteToken: string;
  is_admin: boolean;
}
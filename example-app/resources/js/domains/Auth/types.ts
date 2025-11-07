export interface LoggedInUser {
  id: number;
  name: string;
  email: string;
  inviteToken: string;
  is_admin: boolean;
}

export interface Credentials {
  email: string;
  password: string;
}

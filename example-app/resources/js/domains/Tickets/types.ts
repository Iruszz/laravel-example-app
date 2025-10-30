import type { User } from '../../domains/Auth/types';

export interface Ticket {
    id: number;
    title: string;
    description: string;
    agent_id?: number | null;
    user_id: number;
    status_id: number;
    category_id: number;
    created_at: number;
    user?: User;
    agent?: User;
}

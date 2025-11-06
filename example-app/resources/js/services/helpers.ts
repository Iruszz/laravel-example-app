export function orderBy<T>(array: T[], key: keyof T, ascending: boolean = true): T[] {
    return [...array].sort((a, b) => {
        const aValue = a[key];
        const bValue = b[key];

        if (typeof aValue === 'string' && typeof bValue === 'string') {
            return ascending ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
        }

        if (typeof aValue === 'number' && typeof bValue === 'number') {
            return ascending ? aValue - bValue : bValue - aValue;
        }

        if (aValue instanceof Date && bValue instanceof Date) {
            return ascending ? aValue.getTime() - bValue.getTime() : bValue.getTime() - aValue.getTime();
        }

        return 0;
    });
}
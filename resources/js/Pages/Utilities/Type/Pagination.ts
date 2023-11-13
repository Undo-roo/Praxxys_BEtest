type Links = {
    url: string,
    label: string,
    active: boolean,
}[]

type Pagination = {
    current_page: number,
    from: number,
    per_page: number,
    path: string,
    first_page_url: string,
    last_page_url: string,
    links: Links,
    next_page_url?: string,
    prev_page_url?: string,
    to: number,
    total: number,
}

export type { 
    Links,
    Pagination
}


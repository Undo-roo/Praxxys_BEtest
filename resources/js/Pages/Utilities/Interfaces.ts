interface Icon{
    name: string,
    type?: string,
    size?: string,
}

interface Avatar{
    name?: string,
    img?: string,
}

interface Logo{
    name: string,
    img?: string,
}

interface MenuLinks{
    link: string,
    label: string, 
    component: string,
}

interface Navigations{
    button?: boolean,
    dropdown?: boolean,
    label: string,
    icon?: string,
    link?: string,
    prefix?: string,
    menuLinks ?: MenuLinks[], 
    fontType?: string,
}

interface User{
    
    created_at: string,
    email: string,
    email_verified_at: string,
    id: number,
    name: string,
    username: string,
    updated_at: string,

}

export type { Icon, Avatar, Logo, MenuLinks, Navigations, User };

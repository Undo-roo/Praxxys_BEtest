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

interface Product{
    id: number,
    name: string,
    description: string,
    dateTime: string,
    category_id: number,
    updated_at: string,
    created_at: string,
    price: number,
    path?: string,

}

// interface Category{
//     id: number;
//     title: string;
//     description: string;
//     folder: string;
//     updated_at: string;
//     created_at: string;
// }

interface Cart{
    created_at: string,
    updated_at: string,
    id: number,
    product_id: number,
    user_id: number,
    quantity: number,
    total: number,
}


export type { Icon, Avatar, Logo, MenuLinks, Navigations, User, Product, Cart };

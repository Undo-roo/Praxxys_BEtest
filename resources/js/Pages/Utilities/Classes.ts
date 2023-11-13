
class Category{
    id!: number;
    title!: string;
    description!: string;
    folder!: string;
    updated_at!: string;
    created_at!: string;
}

class Icon{
    name!: string;
    type?: string = 'solid';
    size?: string = '18px';
}

class Product{
    id!: number;
    name!: string;
    description!: string;
    dateTime!: string;
    category_id!: number;
    updated_at!: string;
    created_at!: string;
}

export {
    Category, Icon, Product
};
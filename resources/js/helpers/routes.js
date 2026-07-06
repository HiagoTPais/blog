const ROUTE_PARAMS = {
    'categories.show': 'category',
    'tags.show': 'tag',
    'posts.show': 'post',
};

export function blogRoute(name, params = {}) {
    const required = ROUTE_PARAMS[name];

    if (required && !params[required]) {
        return null;
    }

    try {
        return route(name, params);
    } catch {
        return null;
    }
}

export function breadcrumbHref(crumb) {
    if (!crumb?.href) {
        return null;
    }

    const required = ROUTE_PARAMS[crumb.href];

    if (required) {
        if (!crumb.params?.[required]) {
            return null;
        }

        return blogRoute(crumb.href, crumb.params);
    }

    return blogRoute(crumb.href, crumb.params ?? {});
}

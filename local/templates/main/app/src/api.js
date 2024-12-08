export async function visitPage(data) {
    return await BX.ajax.runAction('module:conversing.Visit.visitPage', data);
}
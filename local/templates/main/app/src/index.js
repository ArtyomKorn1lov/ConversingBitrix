import TagFinder from "./TagFinder";
import {visitPage} from "./api";

BX.ready(() => {
    const tagFinder = new TagFinder();
    console.log('pageParams', pageParams);
    visitPage({
        data: {
            params: pageParams
        }
    })
        .then((response) => {
            console.log(response);
        })
        .catch((error) => {
            console.log(error);
        });
});
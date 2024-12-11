import PageFinder from "./PageFinder";
import {visitPage} from "./api";

BX.ready(() => {
    const pageFinder = new PageFinder(true);
    const finderData = pageFinder.getPageValue();
    let finalPageParams = pageParams;
    finalPageParams.params = {
        ...finalPageParams.params,
        ...finderData
    }
    console.log('finalPageParams', finalPageParams);
    visitPage({
        data: {
            params: finalPageParams
        }
    })
        .then((response) => {
            console.log(response);
        })
        .catch((error) => {
            console.log(error);
        });

    pageFinder.addHandlersActions(conversingDataAttr);
});
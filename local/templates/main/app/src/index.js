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
            !!isUserAdmin && BX.UI.Dialogs.MessageBox.alert(
                response.data
            );
        })
        .catch((error) => {
            console.log(error);
            !!isUserAdmin && BX.UI.Dialogs.MessageBox.alert(
                error.data
            );
        });

    pageFinder.addHandlersActions(conversingDataAttr);
});
import useSettingsContext from '../../context/useSettingsContext';

function GetInitialPage() {
  const {
    rememberFilters,
    userData,
    currentPagePath,
	activePage
  } = useSettingsContext();

  let initialPage;

  if (rememberFilters && userData !== null && userData[currentPagePath] && userData[currentPagePath].page !== undefined) {
	initialPage = userData[currentPagePath].page;
  } else if ('1' !== activePage) {
	initialPage = Number(activePage);
  } else {
	initialPage = 1;
  }
  
  return initialPage;
}

export default GetInitialPage;
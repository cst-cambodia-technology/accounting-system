import { AccountingSystemAppPage } from './app.po';

describe('accounting-system-app App', function() {
  let page: AccountingSystemAppPage;

  beforeEach(() => {
    page = new AccountingSystemAppPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});

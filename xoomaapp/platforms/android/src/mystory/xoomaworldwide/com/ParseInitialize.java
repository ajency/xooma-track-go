package mystory.xoomaworldwide.com;

  import android.app.Application;
  import com.parse.Parse;
  import com.parse.ParseInstallation;

public class ParseInitialize extends Application{
    @Override
    public void onCreate() {
        super.onCreate();
        Parse.initialize(this, "fQBYzCQ6rmU8cTbwBUX5vFqtujZTugSmOPOvm2Tf", "reAavTNAeqb533EiuF0nAK2zl81Wk23gbTnRStz2");
        ParseInstallation.getCurrentInstallation().saveInBackground();
    }
}